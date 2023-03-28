<?php

namespace Goosfraba\KrdRastin\Exception;

/**
 * A base class for specific validation exceptions
 */
abstract class AbstractValidationException extends AbstractKrdRastinException
{
    private ValidationFault $validationFault;

    public function __construct(ValidationFault $validationFault, $message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->validationFault = $validationFault;
    }

    /**
     * Gets the validationFault
     *
     * @return ValidationFault
     */
    public function validationFault(): ValidationFault
    {
        return $this->validationFault;
    }
}
