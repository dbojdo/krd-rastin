<?php

namespace Goosfraba\KrdRastin\Soap;

use Goosfraba\KrdRastin\Exception\GenericException;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveRequest;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveResponse;
use Goosfraba\KrdRastin\VerifyIDCardRequest;
use Goosfraba\KrdRastin\KrdRastinApi;
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberRequest;
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberResponse;
use Goosfraba\KrdRastin\VerifyIDCardResponse;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledRequest;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledResponse;
use Webit\SoapApi\Executor\SoapApiExecutor;

final class KrdRastinSoapApi implements KrdRastinApi
{
    private SoapApiExecutor $soapApiExecutor;

    public function __construct(SoapApiExecutor $soapApiExecutor)
    {
        $this->soapApiExecutor = $soapApiExecutor;
    }

    /**
     * @inheritDoc
     */
    public function verifyConsumerIdentityNumber(VerifyConsumerIdentityNumberRequest $request): VerifyConsumerIdentityNumberResponse
    {
        $result = $this->soapApiExecutor->executeSoapFunction(
            $function = "VerifyConsumerIdentityNumber",
            ["VerifyConsumerIdentityNumberRequest" => $request]
        );

        return $this->assertResultType($result, VerifyConsumerIdentityNumberResponse::class, $function);
    }

    /**
     * @inheritDoc
     */
    public function verifyIdCard(VerifyIDCardRequest $request): VerifyIDCardResponse
    {
        $result = $this->soapApiExecutor->executeSoapFunction(
            $function = "VerifyIDCard",
            ["IDCardRequest" => $request]
        );

        return $this->assertResultType($result, VerifyIDCardResponse::class, $function);
    }

    /**
     * @inheritDoc
     */
    public function verifyIsIdCardCanceled(VerifyIsIDCardCanceledRequest $request): VerifyIsIDCardCanceledResponse
    {
        $result =  $this->soapApiExecutor->executeSoapFunction(
            $function = "VerifyIsIDCardCanceled",
            [
                "VerifyIsIDCardCanceledRequest" => $request
            ]
        );

        return $this->assertResultType($result, VerifyIsIDCardCanceledResponse::class, $function);
    }

    public function verifyConsumerIsAlive(VerifyConsumerIsAliveRequest $request): VerifyConsumerIsAliveResponse
    {
        $result = $this->soapApiExecutor->executeSoapFunction(
            $function = "VerifyConsumerIsAlive",
            [
                "VerifyConsumerIsAliveRequest" => $request
            ]
        );

        return $this->assertResultType($result, VerifyConsumerIsAliveResponse::class, $function);
    }

    private function assertResultType($result, string $className, string $method)
    {
        if ($result instanceof $className) {
            return $result;
        }

        throw new GenericException(
            sprintf(
                'Unexpected result type of method \"%s\". Expected type of \"%s\" but \"%s\" given.',
                $method,
                $className,
                is_object($result) ? get_class($result) : gettype($result),
            ),
        );
    }
}
