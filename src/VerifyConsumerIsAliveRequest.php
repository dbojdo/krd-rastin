<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyConsumerIsAlive request data
 */
final class VerifyConsumerIsAliveRequest
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

    public function __construct(string $pesel, string $name, string $lastName)
    {
        $this->pesel = $pesel;
        $this->name = $name;
        $this->lastName = $lastName;
    }

    /**
     * A static constructor. A convenience method.
     *
     * @param string $pesel
     * @param string $name
     * @param string $lastName
     * @return VerifyConsumerIsAliveRequest
     */
    public static function create(string $pesel, string $name, string $lastName): self
    {
        return new self($pesel, $name, $lastName);
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
}
