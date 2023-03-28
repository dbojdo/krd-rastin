<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyConsumerIdentityNumber request data
 */
final class VerifyConsumerIdentityNumberRequest
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("ConsumerIdentityNumber")
     */
    private string $pesel;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("FirstName")
     */
    private string $name;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Surname")
     */
    private string $lastName;

    /**
     * @JMS\Type("Goosfraba\KrdRastin\Address")
     * @JMS\SerializedName("PermanentAddress")
     */
    private ?Address $permanentAddress = null;

    /**
     * @JMS\Type("Goosfraba\KrdRastin\Address")
     * @JMS\SerializedName("TemporaryAddress)")
     */
    private ?Address $temporaryAddress = null;

    public function __construct(
        string $pesel,
        string $name,
        string $lastName,
        ?Address $permanentAddress = null,
        ?Address $temporaryAddress = null
    ) {
        $this->pesel = $pesel;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->permanentAddress = $permanentAddress;
        $this->temporaryAddress = $temporaryAddress;
    }

    /**
     * A static constructor. A convenience method.
     *
     * @param string $pesel
     * @param string $name
     * @param string $lastName
     * @param Address|null $permanentAddress
     * @param Address|null $temporaryAddress
     * @return VerifyConsumerIdentityNumberRequest
     */
    public static function create(
        string $pesel,
        string $name,
        string $lastName,
        ?Address $permanentAddress = null,
        ?Address $temporaryAddress = null
    ): self {
        return new self($pesel, $name, $lastName, $permanentAddress, $temporaryAddress);
    }

    /**
     * Gets the pesel
     *
     * @return string
     */
    public function pesel(): string
    {
        return $this->pesel;
    }

    /**
     * Gets the name
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Gets the lastName
     *
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * Gets the permanentAddress
     *
     * @return Address|null
     */
    public function permanentAddress(): ?Address
    {
        return $this->permanentAddress;
    }

    /**
     * Gets the temporaryAddress
     *
     * @return Address|null
     */
    public function temporaryAddress(): ?Address
    {
        return $this->temporaryAddress;
    }
}
