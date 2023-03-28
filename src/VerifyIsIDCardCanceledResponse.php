<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyIsIDCardCanceled response data
 */
final class VerifyIsIDCardCanceledResponse
{
    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("Canceled")
     */
    private ?bool $isCanceled;

    public function __construct(?bool $isCanceled = null)
    {
        $this->isCanceled = $isCanceled;
    }

    /**
     * Gets isCanceled
     *
     * @return bool
     */
    public function isCanceled(): bool
    {
        return (bool)$this->isCanceled;
    }
}
