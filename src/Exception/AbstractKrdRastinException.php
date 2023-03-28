<?php

namespace Goosfraba\KrdRastin\Exception;

/**
 * A base class for specific exceptions
 */
abstract class AbstractKrdRastinException extends \RuntimeException implements KrdRastinException
{
    /**
     * @inheritDoc
     */
    public function soapFault(): ?\SoapFault
    {
        $soapFault = $this;
        while ($soapFault && !($soapFault instanceof \SoapFault)) {
            $soapFault = $soapFault->getPrevious();
        }

        return $soapFault instanceof \SoapFault ? $soapFault : null;
    }
}
