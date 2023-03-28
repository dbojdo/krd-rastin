<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyConsumerIsAlive response data
 */
final class VerifyConsumerIsAliveResponse
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Status")
     */
    private ?string $status;

    public function __construct(?string $status = null)
    {
        $this->status = $status;
    }

    /**
     * Gets the status
     *
     * @return VerifyConsumerIsAliveStatus|null
     */
    public function status(): ?VerifyConsumerIsAliveStatus
    {
        return VerifyConsumerIsAliveStatus::tryParse((string)$this->status);
    }
}
