<?php

namespace Goosfraba\KrdRastin;

/**
 * The full name
 */
final class FullName
{
    private string $name;
    private ?string $middleName;

    private string $lastNamePart1;

    private ?string $lastNamePart2;

    public function __construct(string $name, ?string $middleName, string $lastNamePart1, ?string $lastNamePart2 = null)
    {
        $this->name = $name;
        $this->middleName = $middleName;
        $this->lastNamePart1 = $lastNamePart1;
        $this->lastNamePart2 = $lastNamePart2;
    }

    /**
     * A named constructor. Creates an instance with the lastname.
     *
     * @param string $name
     * @param string|null $middleName
     * @param string $lastName
     * @return FullName
     */
    public static function createWithLastName(string $name, ?string $middleName, string $lastName): self
    {
        $lastName1 = $lastName;
        $lastName2 = null;
        if (false !== $dash = strpos($lastName, "-")) {
            $lastName1 = substr($lastName, 0, $dash + 1);
            $lastName2 = substr($lastName, $dash + 1);
        }

        return new self($name, $middleName, $lastName1, $lastName2);
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
     * Gets the middleName
     *
     * @return string|null
     */
    public function middleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * Gets the lastNamePart1
     *
     * @return string
     */
    public function lastNamePart1(): string
    {
        return $this->lastNamePart1;
    }

    /**
     * Gets the lastNamePart2
     *
     * @return string|null
     */
    public function lastNamePart2(): ?string
    {
        return $this->lastNamePart2;
    }

    /**
     * Gets the last name
     *
     * @return string
     */
    public function lastName(): string
    {
        return $this->lastNamePart1() . $this->lastNamePart2();
    }
}
