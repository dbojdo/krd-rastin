<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The address verification result
 */
final class AddressVerificationResult
{
    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("StreetIsValid")
     */
    private ?bool $isStreetValid = null;

    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("BuildingIsValid")
     */
    private ?bool $isBuildingValid = null;

    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("FlatIsValid")
     */
    private ?bool $isFlatValid = null;

    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("ZipCodeIsValid")
     */
    private ?bool $isPostCodeValid = null;

    /**
     * @JMS\Type("bool")
     * @JMS\SerializedName("CityIsValid")
     */
    private ?bool $isCityValid = null;

    public function __construct(
        ?bool $isStreetValid = null,
        ?bool $isBuildingValid = null,
        ?bool $isFlatValid = null,
        ?bool $isPostCodeValid = null,
        ?bool $isCityValid = null
    ) {
        $this->isStreetValid = $isStreetValid;
        $this->isBuildingValid = $isBuildingValid;
        $this->isFlatValid = $isFlatValid;
        $this->isPostCodeValid = $isPostCodeValid;
        $this->isCityValid = $isCityValid;
    }

    /**
     * Gets the isStreetValid
     *
     * @return bool
     */
    public function isStreetValid(): bool
    {
        return (bool)$this->isStreetValid;
    }

    /**
     * Gets the isBuildingValid
     *
     * @return bool
     */
    public function isBuildingValid(): bool
    {
        return (bool)$this->isBuildingValid;
    }

    /**
     * Gets the isFlatValid
     *
     * @return bool
     */
    public function isFlatValid(): bool
    {
        return (bool)$this->isFlatValid;
    }

    /**
     * Gets the isPostCodeValid
     *
     * @return bool
     */
    public function isPostCodeValid(): bool
    {
        return (bool)$this->isPostCodeValid;
    }

    /**
     * Gets the isCityValid
     *
     * @return bool
     */
    public function isCityValid(): bool
    {
        return (bool)$this->isCityValid;
    }
}
