<?php

namespace Goosfraba\KrdRastin\Exception;

/**
 * An exception thrown by the KrdRastin API
 */
interface KrdRastinException extends \Throwable
{
    /**
     * Gets an underlying \SoapFault
     *
     * @return \SoapFault|null
     */
    public function soapFault(): ?\SoapFault;
}
