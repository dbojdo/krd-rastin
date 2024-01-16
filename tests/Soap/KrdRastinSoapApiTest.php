<?php

namespace Goosfraba\KrdRastin\Soap;

use Faker\Factory;
use Faker\Generator;
use Goosfraba\KrdRastin\Address;
use Goosfraba\KrdRastin\AddressVerificationResult;
use Goosfraba\KrdRastin\Exception\AuthenticationException;
use Goosfraba\KrdRastin\Exception\GenericException;
use Goosfraba\KrdRastin\Exception\ValidationException;
use Goosfraba\KrdRastin\FullName;
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberRequest;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveRequest;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveStatus;
use Goosfraba\KrdRastin\VerifyIDCardRequest;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Webit\SoapApi\Executor\SoapApiExecutor;

class KrdRastinSoapApiTest extends TestCase
{
    use ProphecyTrait;

    private static Generator $faker;
    private KrdRastinSoapApi $api;

    protected function setUp(): void
    {
        self::$faker = Factory::create('pl');

        $dsn = getenv("KRD_RASTIN_DSN");
        if (!$dsn) {
            $this->markTestSkipped("KRD_RASTIN_DSN must be set in phpunit.xml");
        }

        $this->api = KrdRastinSoapApiFactory::getInstance()->createFromDsn(
            Dsn::parse($dsn)
        );
    }

    /**
     * @test
     */
    public function itThrowsAuthenticationExceptionOnInvalidCredentials(): void
    {
        $this->api = KrdRastinSoapApiFactory::getInstance()->createDemo(
            Authorization::loginAndPassword("unknwon", "wrong-password" . mt_rand(0, 10000))
        );
        $this->expectException(AuthenticationException::class);
        $this->api->verifyIsIdCardCanceled(
            VerifyIsIDCardCanceledRequest::create("abc", "1234")
        );
    }

    /**
     * @test
     * @dataProvider peselsAndAddresses
     */
    public function itVerifiesConsumerIdentityNumber(
        VerifyConsumerIdentityNumberRequest $request,
        bool $isPeselValid,
        AddressVerificationResult $permanentAddress
    ): void {
        $response = $this->api->verifyConsumerIdentityNumber($request);

        $this->assertEquals($isPeselValid, $response->isPeselValid());
        $this->assertEquals($permanentAddress, $response->permanentAddressVerificationResult());
    }

    public static function peselsAndAddresses(): array
    {
        return [
            [
                VerifyConsumerIdentityNumberRequest::create(
                    "13300100037",
                    "OKTAWIUSZ",
                    "DE LORM",
                    Address::create(
                        "GÓRNICZA",
                        "39",
                        "20",
                        "01203",
                        "JÓZEFÓW"
                    )
                ),
                true,
                new AddressVerificationResult(true, true, true, true, true),
                new AddressVerificationResult(),
            ],
            "invalid address" => [
                VerifyConsumerIdentityNumberRequest::create(
                    "13300100037",
                    "OKTAWIUSZ",
                    "DE LORM",
                    Address::create(
                        "GÓRNICA",
                        "39",
                        "2",
                        "01203",
                        "JÓZEFÓW"
                    )
                ),
                true,
                new AddressVerificationResult(false, true, false, true, true),
                new AddressVerificationResult(),
            ],
            "PESEL does not match the name" => [
                VerifyConsumerIdentityNumberRequest::create(
                    "13300100037",
                    "ADAM",
                    "DE LORM",
                    Address::create(
                        "GÓRNICZA",
                        "39",
                        "20",
                        "01203",
                        "JÓZEFÓW"
                    )
                ),
                false,
                new AddressVerificationResult(),
                new AddressVerificationResult(),
            ],
            "invalid PESEL" => [
                VerifyConsumerIdentityNumberRequest::create(
                    "23307700037",
                    "OKTAWIUSZ",
                    "DE LORM",
                    Address::create(
                        "GÓRNICZA",
                        "39",
                        "20",
                        "01203",
                        "JÓZEFÓW"
                    )
                ),
                false,
                new AddressVerificationResult(),
                new AddressVerificationResult(),
            ],
        ];
    }

    /**
     * @test
     * @dataProvider idCards
     */
    public function itVerifiesIdCard(VerifyIDCardRequest $request, bool $isValid): void
    {
        $response = $this->api->verifyIdCard($request);

        $this->assertEquals($isValid, $response->isValid());
    }

    public static function idCards(): array
    {
        return [
            [
                VerifyIDCardRequest::create(
                    "84113000025",
                    FullName::createWithLastName("JOANNA", null, "BURSKA"),
                    "DAS",
                    "678134",
                    date_create_immutable("2014-09-25"),
                    date_create_immutable("2024-09-25")
                ),
                true, // WYDANY
            ],
            [
                VerifyIDCardRequest::create(
                    "51011500014",
                    FullName::createWithLastName("ANDRZEJ", "PAWEŁ", "WALCZUK-KOWALSKA"),
                    "VCX",
                    "959351",
                    date_create_immutable("2014-09-24"),
                    date_create_immutable("2024-09-24")
                ),
                false, // UNIEWAŻNIONY
            ],
            [
                VerifyIDCardRequest::create(
                    "98120900234",
                    FullName::createWithLastName("CUONG", null, "VAN DIJK"),
                    "AAP",
                    "234189",
                    date_create_immutable("2017-09-19"),
                    date_create_immutable("2027-09-19")
                ),
                true, // WYDANY
            ],
            "invalid ID Card" => [
                VerifyIDCardRequest::create(
                    "98120900234",
                    FullName::createWithLastName("CUONG", null, "VAN DIJK"),
                    "AAP",
                    "134189",
                    date_create_immutable("2017-09-19"),
                    date_create_immutable("2027-09-19")
                ),
                false,
            ],
            "invalid valid to date" => [
                VerifyIDCardRequest::create(
                    "98120900234",
                    FullName::createWithLastName("CUONG", null, "VAN DIJK"),
                    "AAP",
                    "134189",
                    date_create_immutable("1992-09-19")
                ),
                false,
            ],
        ];
    }

    /**
     * @test
     */
    public function itThrowsValidationExceptionOnInvalidPesel(): void
    {
        $this->expectException(ValidationException::class);
        $this->api->verifyIdCard(
            VerifyIDCardRequest::create(
                "98120900235",
                FullName::createWithLastName("CUONG", null, "VAN DIJK"),
                "AAP",
                "234189",
                date_create_immutable("2017-09-19"),
                date_create_immutable("2027-09-19")
            )
        );
    }

    /**
     * @test
     * @dataProvider idCardsCanceled
     */
    public function itVerifiesIfIdCardIsCanceled(VerifyIsIDCardCanceledRequest $request, bool $isCanceled): void
    {
        $response = $this->api->verifyIsIdCardCanceled($request);

        $this->assertEquals($isCanceled, $response->isCanceled());
    }

    public static function idCardsCanceled(): array
    {
        return [
            [
                VerifyIsIDCardCanceledRequest::create("DAS", "678134"),
                false,
            ],
            [
                VerifyIsIDCardCanceledRequest::create("VCX", "959351"),
                true,
            ],
            [
                VerifyIsIDCardCanceledRequest::create("AAP", "234189"),
                false,
            ],
            "invalid ID card" => [
                VerifyIsIDCardCanceledRequest::create("ANC", "134189"),
                false,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider consumersAlive
     */
    public function itVerifiesIfConsumerIsAlive(VerifyConsumerIsAliveRequest $request, VerifyConsumerIsAliveStatus $status): void
    {
        $response = $this->api->verifyConsumerIsAlive($request);

        $this->assertEquals($status, $response->status());
    }

    public static function consumersAlive(): array
    {
        return [
            [VerifyConsumerIsAliveRequest::create("14221400248", "DELFFINA", "TONDOSSSS"), VerifyConsumerIsAliveStatus::alive()],
            [VerifyConsumerIsAliveRequest::create("04220800193", "AUSTIN", "HIPNAROWICZ"), VerifyConsumerIsAliveStatus::incorrectData()],
        ];
    }

    /**
     * @test
     */
    public function itAssertsResultType(): void
    {
        $soapExecutor = $this->prophesize(SoapApiExecutor::class);
        $soapExecutor->executeSoapFunction(
            'VerifyConsumerIdentityNumber',
            [
                'VerifyConsumerIdentityNumberRequest' => $request = VerifyConsumerIdentityNumberRequest::create(
                    '8723345602',
                    self::$faker->firstName(),
                    self::$faker->lastName(),
                )
            ]
        )->willReturn(null);

        $this->expectException(GenericException::class);

        $api = new KrdRastinSoapApi($soapExecutor->reveal());
        $api->verifyConsumerIdentityNumber($request);
    }
}
