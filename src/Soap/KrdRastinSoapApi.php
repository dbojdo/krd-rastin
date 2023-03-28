<?php

namespace Goosfraba\KrdRastin\Soap;

use Goosfraba\KrdRastin\VerifyConsumerIsAliveRequest;
use Goosfraba\KrdRastin\VerifyConsumerIsAliveResponse;
use Goosfraba\KrdRastin\VerifyIDCardRequest;
use Goosfraba\KrdRastin\KrdRastinApi;
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberRequest;
use Goosfraba\KrdRastin\VerifyConsumerIdentityNumberResponse;
use Goosfraba\KrdRastin\VerifyIDCardResponse;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledRequest;
use Goosfraba\KrdRastin\VerifyIsIDCardCanceledResponse;
use Webit\SoapApi\Executor\Exception\ExecutorException;
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
        return $this->soapApiExecutor->executeSoapFunction(
            "VerifyConsumerIdentityNumber",
            ["VerifyConsumerIdentityNumberRequest" => $request]
        );
    }

    /**
     * @inheritDoc
     */
    public function verifyIdCard(VerifyIDCardRequest $request): VerifyIDCardResponse
    {
        return $this->soapApiExecutor->executeSoapFunction(
            "VerifyIDCard",
            ["IDCardRequest" => $request]
        );
    }

    /**
     * @inheritDoc
     */
    public function verifyIsIdCardCanceled(VerifyIsIDCardCanceledRequest $request): VerifyIsIDCardCanceledResponse
    {
        return $this->soapApiExecutor->executeSoapFunction(
            "VerifyIsIDCardCanceled",
            [
                "VerifyIsIDCardCanceledRequest" => $request
            ]
        );
    }

    public function verifyConsumerIsAlive(VerifyConsumerIsAliveRequest $request): VerifyConsumerIsAliveResponse
    {
        return $this->soapApiExecutor->executeSoapFunction(
            "VerifyConsumerIsAlive",
            [
                "VerifyConsumerIsAliveRequest" => $request
            ]
        );
    }
}
