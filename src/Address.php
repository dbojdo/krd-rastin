<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The address to be verified
 */
final class Address
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Street")
     */
    private string $street;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Building")
     */
    private string $building;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("Flat")
     */
    private ?string $flat;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("ZipCode")
     */
    private string $postCode;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("City")
     */
    private string $city;

    public function __construct(string $street, string $building, ?string $flat, string $postCode, string $city)
    {
        $this->street = $street;
        $this->building = $building;
        $this->flat = $flat;
        $this->postCode = preg_replace("/\D/", "", $postCode);
        $this->city = $city;
    }

    /**
     * A static constructor. A convenience method.
     *
     * @param string $street
     * @param string $building
     * @param string|null $flat
     * @param string $postCode
     * @param string $city
     * @return Address
     */
    public static function create(string $street, string $building, ?string $flat, string $postCode, string $city): self
    {
        return new self($street, $building, $flat, $postCode, $city);
    }

    /**
     * Gets the street
     *
     * @return string
     */
    public function street(): string
    {
        return $this->street;
    }

    /**
     * Gets the building
     *
     * @return string
     */
    public function building(): string
    {
        return $this->building;
    }

    /**
     * Gets the flat
     *
     * @return string|null
     */
    public function flat(): ?string
    {
        return $this->flat;
    }

    /**
     * Gets the postCode
     *
     * @return string
     */
    public function postCode(): string
    {
        return $this->postCode;
    }

    /**
     * Gets the city
     *
     * @return string
     */
    public function city(): string
    {
        return $this->city;
    }
}
