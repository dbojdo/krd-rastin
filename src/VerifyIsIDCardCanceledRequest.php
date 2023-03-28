<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyIsIDCardCanceled request data
 */
final class VerifyIsIDCardCanceledRequest
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("IDCardSeries")
     */
    private string $series;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("IDCardNumber")
     */
    private string $number;

    public function __construct(string $series, string $number)
    {
        $this->series = $series;
        $this->number = $number;
    }

    /**
     * A static constructor. A convenience method.
     */
    public static function create(string $series, string $number): self
    {
        return new self($series, $number);
    }

    /**
     * Gets the series
     *
     * @return string
     */
    public function series(): string
    {
        return $this->series;
    }

    /**
     * Gets the number
     *
     * @return string
     */
    public function number(): string
    {
        return $this->number;
    }
}
