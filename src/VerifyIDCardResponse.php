<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyIDCard response data
 */
final class VerifyIDCardResponse
{
    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("IsValid")
     */
    private ?bool $isValid = null;

    public function __construct(?bool $isValid = null)
    {
        $this->isValid = $isValid;
    }

    /**
     * Gets the isValid
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return (bool)$this->isValid;
    }
}
