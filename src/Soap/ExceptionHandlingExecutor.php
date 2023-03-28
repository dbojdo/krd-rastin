<?php

namespace Goosfraba\KrdRastin\Soap;

use Goosfraba\KrdRastin\Exception\AuthenticationException;
use Goosfraba\KrdRastin\Exception\GenericException;
use Goosfraba\KrdRastin\Exception\KrdRastinException;
use Goosfraba\KrdRastin\Exception\SchemaValidationException;
use Goosfraba\KrdRastin\Exception\ValidationException;
use Goosfraba\KrdRastin\Exception\ValidationFault;
use Webit\SoapApi\Executor\Exception\ExecutorException;
use Webit\SoapApi\Executor\SoapApiExecutor;
use Webit\SoapApi\Util\StdClassToArray;

/**
 * Executes the SOAP function and wraps potential exception
 */
final class ExceptionHandlingExecutor implements SoapApiExecutor
{
    private SoapApiExecutor $innerExecutor;
    private StdClassToArray $toArray;

    public function __construct(SoapApiExecutor $innerExecutor)
    {
        $this->innerExecutor = $innerExecutor;
        $this->toArray = new StdClassToArray();
    }

    /**
     * @inheritDoc
     */
    public function executeSoapFunction($soapFunction, $input = null, array $options = [], array $headers = [])
    {
        try {
            return $this->innerExecutor->executeSoapFunction($soapFunction, $input, $options, $headers);
        } catch (ExecutorException $e) {
            throw $this->createException($e);
        }
    }

    /**
     * Creates an KrdRastin exception instance
     */
    private function createException(ExecutorException $e): KrdRastinException
    {
        $soapFault = $e->getPrevious();
        if (!($soapFault instanceof \SoapFault)) {
            throw new GenericException($e->getMessage(), $e->getCode(), $e);
        }

        $detail = $this->toArray->toArray($soapFault->detail);
        switch($soapFault->faultcode) {
            case "s:IncorrectCredentials":
                // SecurityFault
                return new AuthenticationException($soapFault->faultstring, $e->getCode(), $e);
            case "s:DataIsNotValid":
                // ValidationFault
                return new ValidationException(
                    $this->validationFault($detail['ValidationFault'] ?? []),
                    $soapFault->faultstring,
                    $e->getCode(),
                    $e
                );
            case "MessageIsNotValid":
                // SchemaValidationFault
                return new SchemaValidationException(
                    $this->validationFault($detail['SchemaValidationFault'] ?? []),
                    $soapFault->faultstring,
                    $e->getCode(),
                    $e
                );
            default:
                throw new GenericException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Creates the validation fault from given SOAP fault details
     *
     * @param array $detail
     * @return ValidationFault
     */
    private function validationFault(array $detail): ValidationFault
    {
        $arValidationFault = $detail["Details"]["Detail"] ?? [];
        if (!$arValidationFault) {
            return new ValidationFault();
        }

        return new ValidationFault(
            $arValidationFault['Key'] ?? null,
            $arValidationFault['Message']['Text'] ?? []
        );
    }
}
