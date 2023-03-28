<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyConsumerIdentityNumber response data
 */
final class VerifyConsumerIdentityNumberResponse
{
    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("ConsumerIdentytyNumberIsValid")
     */
    private ?bool $isPeselValid = null;

    /**
     * @JMS\Type("Goosfraba\KrdRastin\AddressVerificationResult")
     * @JMS\SerializedName("PermanentAddressVerificationResult")
     */
    private ?AddressVerificationResult $permanentAddressVerificationResult = null;

    /**
     * @JMS\Type("Goosfraba\KrdRastin\AddressVerificationResult")
     * @JMS\SerializedName("TemporaryAddressVerificationResult")
     */
    private ?AddressVerificationResult $temporaryAddressVerificationResult = null;

    public function __construct(
        ?bool $isPeselValid = null,
        ?AddressVerificationResult $permanentAddressVerificationResult = null,
        ?AddressVerificationResult $temporaryAddressVerificationResult = null
    ) {
        $this->isPeselValid = $isPeselValid;
        $this->permanentAddressVerificationResult = $permanentAddressVerificationResult;
        $this->temporaryAddressVerificationResult = $temporaryAddressVerificationResult;
    }

    /**
     * Gets the isPeselValid
     *
     * @return bool
     */
    public function isPeselValid(): bool
    {
        return (bool)$this->isPeselValid;
    }

    /**
     * Gets the permanentAddressVerificationResult
     *
     * @return AddressVerificationResult|null
     */
    public function permanentAddressVerificationResult(): AddressVerificationResult
    {
        return $this->permanentAddressVerificationResult ?? new AddressVerificationResult();
    }

    /**
     * Gets the temporaryAddressVerificationResult
     *
     * @return AddressVerificationResult|null
     */
    public function temporaryAddressVerificationResult(): ?AddressVerificationResult
    {
        return $this->temporaryAddressVerificationResult ?? new AddressVerificationResult();
    }
}
