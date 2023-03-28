<?php

namespace Goosfraba\KrdRastin;

use JMS\Serializer\Annotation as JMS;

/**
 * The VerifyIDCard request data
 */
final class VerifyIDCardRequest
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
     * @JMS\SerializedName("SecondName")
     */
    private ?string $middleName;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("SurnameFirstPart")
     */
    private string $lastNamePart1;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("SurnameSecondPart")
     */
    private ?string $lastNamePart2;

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


    /**
     * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
     * @JMS\SerializedName("ProductionDate")
     */
    private \DateTimeInterface $issuedAt;

    /**
     * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
     * @JMS\SerializedName("ExpirationDate")
     */
    private ?\DateTimeInterface $validTo;

    public function __construct(
        string $pesel,
        FullName $fullName,
        string $series,
        string $number,
        \DateTimeInterface $issuedAt,
        ?\DateTimeInterface $validTo
    ) {
        $this->pesel = $pesel;
        $this->name = $fullName->name();
        $this->middleName = $fullName->middleName();
        $this->lastNamePart1 = $fullName->lastNamePart1();
        $this->lastNamePart2 = $fullName->lastNamePart2();
        $this->series = $series;
        $this->number = $number;
        $this->issuedAt = $issuedAt;
        $this->validTo = $validTo;
    }

    /**
     * A static constructor. A convenience method.
     *
     * @param string $pesel
     * @param FullName $fullName
     * @param string $series
     * @param string $number
     * @param \DateTimeInterface $issuedAt
     * @param \DateTimeInterface|null $validTo
     * @return VerifyIDCardRequest
     */
    public static function create(
        string $pesel,
        FullName $fullName,
        string $series,
        string $number,
        \DateTimeInterface $issuedAt,
        ?\DateTimeInterface $validTo = null
    ): self {
        return new self($pesel, $fullName, $series, $number, $issuedAt, $validTo);
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
     * Gets the full name
     *
     * @return FullName
     */
    public function getFullName(): FullName
    {
        return new FullName($this->name, $this->middleName, $this->lastNamePart1, $this->lastNamePart2);
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

    /**
     * Gets the issuedAt
     *
     * @return \DateTimeInterface
     */
    public function issuedAt(): \DateTimeInterface
    {
        return $this->issuedAt;
    }

    /**
     * Gets the validTo
     *
     * @return \DateTimeInterface|null
     */
    public function validTo(): ?\DateTimeInterface
    {
        return $this->validTo;
    }
}
