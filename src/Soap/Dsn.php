<?php

namespace Goosfraba\KrdRastin\Soap;

final class Dsn
{
    private const SCHEME = "krd+rastin";
    public const ENV_DEMO = "demo";
    public const ENV_PROD = "prod";

    private string $env;
    private string $login;
    private string $password;

    public function __construct(string $env, string $login, string $password)
    {
        $this->env = strtolower($env);
        if (!in_array($this->env, [self::ENV_DEMO, self::ENV_PROD])) {
            throw new \InvalidArgumentException("The env must be only one of [\"demo\", \"prod\"]");
        }

        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Gets the env
     */
    public function env(): string
    {
        return $this->env;
    }

    /**
     * Gets the login
     */
    public function login(): string
    {
        return $this->login;
    }

    /**
     * Gets the password
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * Parses given DSN string (krd+rastin://login:password@demo)
     * Env must be one of "demo" or "prod"
     *
     * @param string $dsn
     * @return self
     */
    public static function parse(string $dsn): self
    {
        $arUrl = parse_url($dsn);
        if ($arUrl['scheme'] !== self::SCHEME) {
            throw new \InvalidArgumentException(sprintf("The scheme must be \"%s\" only.", self::SCHEME));
        }

        return new self(
            $arUrl['host'] ?? "",
            $arUrl['user'] ?? "",
            $arUrl['pass'] ?? ""
        );
    }
}
