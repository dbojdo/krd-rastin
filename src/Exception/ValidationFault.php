<?php

namespace Goosfraba\KrdRastin\Exception;

/**
 * Represents the validation fault
 */
final class ValidationFault
{
    private ?string $key;
    private array $messages;

    public function __construct(?string $key = null, array $messages = [])
    {
        $this->key = $key;
        $this->messages = $messages;
    }

    /**
     * Gets the invalid key
     *
     * @return string|null
     */
    public function key(): ?string
    {
        return $this->key;
    }

    /**
     * Gets the messages
     *
     * @return string[]
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * Gets the first message
     *
     * @return string|null
     */
    public function firstMessage(): ?string
    {
        $messages = $this->messages;
        return array_shift($messages);
    }
}
