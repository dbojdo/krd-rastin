<?php

namespace Goosfraba\KrdRastin\Soap;

use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberResponse;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveResponse;
use Goosfraba\KrdRastin\VerifyIDCardResponse;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledResponse;
use JMS\Serializer\SerializerBuilder;
use Webit\SoapApi\Executor\SoapApiExecutor;
use Webit\SoapApi\Executor\SoapApiExecutorBuilder;
use Webit\SoapApi\Hydrator\ArrayHydrator;
use Webit\SoapApi\Hydrator\ChainHydrator;
use Webit\SoapApi\Hydrator\HydratorSerializerBased;
use Webit\SoapApi\Hydrator\Serializer\ResultTypeMap;
use Webit\SoapApi\Input\InputNormaliserSerializerBased;
use Webit\SoapApi\Input\Serializer\StaticSerializationContextFactory;
use Webit\SoapApi\Util\StdClassToArray;

final class KrdRastinSoapApiFactory
{
    /**
     * Creates an instance of the factory
     */
    public static function getInstance(): self
    {
        return new self();
    }

    /**
     * Creates a production API
     *
     * @param Authorization $authorization
     * @return KrdRastinSoapApi
     */
    public function createProd(
        Authorization $authorization
    ): KrdRastinSoapApi {
        return new KrdRastinSoapApi($this->createExecutor(KrdRastinWsdl::prod(), $authorization));
    }

    /**
     * Creates a demo API
     *
     * @param Authorization $authorization
     * @return KrdRastinSoapApi
     */
    public function createDemo(
        Authorization $authorization
    ): KrdRastinSoapApi {
        return new KrdRastinSoapApi($this->createExecutor(KrdRastinWsdl::demo(), $authorization));
    }

    /**
     * Creates a custom WSDL API
     *
     * @param KrdRastinWsdl $wsdl
     * @param Authorization $authorization
     * @return KrdRastinSoapApi
     */
    public function createCustom(
        KrdRastinWsdl $wsdl,
        Authorization $authorization
    ): KrdRastinSoapApi {
        return new KrdRastinSoapApi($this->createExecutor($wsdl, $authorization));
    }

    /**
     * Creates the API from given DSN
     *
     * @param Dsn $dsn
     * @return KrdRastinSoapApi
     */
    public function createFromDsn(Dsn $dsn): KrdRastinSoapApi
    {
        $authorization = Authorization::loginAndPassword($dsn->login(), $dsn->password());
        switch ($dsn->env()) {
            case Dsn::ENV_PROD:
                return $this->createProd($authorization);
            default:
                return $this->createDemo($authorization);
        }
    }

    /**
     * Creates a SoapApiExecutor
     *
     * @param KrdRastinWsdl $wsdl
     * @param Authorization $authorization
     * @return SoapApiExecutor
     */
    private function createExecutor(KrdRastinWsdl $wsdl, Authorization $authorization): SoapApiExecutor
    {
        $executorBuilder = SoapApiExecutorBuilder::create();

        $serializer = SerializerBuilder::create()->build();

        $executorBuilder->setInputNormaliser(
            new InputNormaliserSerializerBased($serializer, new StaticSerializationContextFactory())
        );

        $executorBuilder->setExecutionHeaders([$authorization->toSoapHeader()]);
        $executorBuilder->setWsdl((string)$wsdl);

        $executorBuilder->setHydrator(
            new ChainHydrator(
                [
                    new ArrayHydrator(new StdClassToArray()),
                    new HydratorSerializerBased(
                        $serializer,
                        $this->resultTypeMap()
                    )
                ]
            )
        );

        return new ExceptionHandlingExecutor($executorBuilder->build());
    }

    private function resultTypeMap(): ResultTypeMap
    {
        return new ResultTypeMap(
            [
                'VerifyConsumerIdentityNumber' => VerifyConsumerIdentityNumberResponse::class,
                'VerifyIDCard' => VerifyIDCardResponse::class,
                'VerifyIsIDCardCanceled' => VerifyIsIDCardCanceledResponse::class,
                'VerifyConsumerIsAlive' => VerifyConsumerIsAliveResponse::class
            ]
        );
    }
}
