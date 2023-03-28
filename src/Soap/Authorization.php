<?php

namespace Goosfraba\KrdRastin\Soap;

/**
 * Represents an authorization data
 */
final class Authorization
{
    private const AUTH_NAMESPACE = "http://krd.pl/Authorization";

    private string $authorizationType;

    private ?string $login;

    private ?string $password;

    private ?string $ticket;

    private function __construct(
        string $authorizationType,
        ?string $login = null,
        ?string $password = null,
        ?string $ticket = null
    ) {
        $this->authorizationType = $authorizationType;
        $this->login = $login;
        $this->password = $password;
        $this->ticket = $ticket;
    }

    public static function loginAndPassword(string $login, string $password): Authorization
    {
        return new self(AuthorizationType::LOGIN_AND_PASSWORD, $login, $password);
    }

    public static function loginAndPasswordHash(string $login, string $password): Authorization
    {
        return new self(AuthorizationType::LOGIN_AND_PASSWORD_HASH, $login, sha1($password));
    }

    public static function ticket(string $ticket): Authorization
    {
        return new self(AuthorizationType::TICKET, null, null, $ticket);
    }

    public function toSoapHeader(): \SoapHeader
    {
        $headerData = [
            "AuthorizationType" => $this->authorizationType
        ];
        switch ($this->authorizationType) {
            case AuthorizationType::LOGIN_AND_PASSWORD:
                $headerData["Login"] = $this->login;
                $headerData["Password"] = $this->password;
                break;
            case AuthorizationType::LOGIN_AND_PASSWORD_HASH:
                $headerData["Login"] = $this->login;
                $headerData["PasswordHash"] = $this->password;
                break;
            case AuthorizationType::TICKET:
                $headerData["Ticket"] = $this->ticket;
                break;
            default:
                throw new \OutOfBoundsException(
                    sprintf("Unsupported authorization type \"%s\".", $this->authorizationType)
                );
        }

        return new \SoapHeader(
            self::AUTH_NAMESPACE,
            "Authorization",
            $headerData
        );
    }
}
