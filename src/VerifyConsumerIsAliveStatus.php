<?php

namespace Goosfraba\KrdRastin;

/**
 * The enum representing possible VerifyConsumerIsAlive response data status
 */
final class VerifyConsumerIsAliveStatus
{
    private const STATUS_ALIVE = "alive";
    private const STATUS_NOT_ALIVE = "notAlive";
    private const STATUS_INCORRECT_DATA = "incorrectData";

    private string $status;

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * Gets alive status
     *
     * @return self
     */
    public static function alive(): self
    {
        return new self(self::STATUS_ALIVE);
    }

    /**
     * Gets not alive status
     *
     * @return self
     */
    public static function notAlive(): self
    {
        return new self(self::STATUS_NOT_ALIVE);
    }

    /**
     * Gets incorrect data status
     *
     * @return self
     */
    public static function incorrectData(): self
    {
        return new self(self::STATUS_INCORRECT_DATA);
    }

    /**
     * Tries to parse given string as a status
     *
     * @param string $status
     * @return self|null
     */
    public static function tryParse(string $status): ?self
    {
        switch (strtolower($status)) {
            case strtolower(self::STATUS_ALIVE):
                return self::alive();
            case strtolower(self::STATUS_NOT_ALIVE):
                return self::notAlive();
            case strtolower(self::STATUS_INCORRECT_DATA):
                return self::incorrectData();
            default:
                return null;
        }
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
