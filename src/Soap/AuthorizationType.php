<?php

namespace Goosfraba\KrdRastin\Soap;

final class AuthorizationType
{
    public const LOGIN_AND_PASSWORD = "LoginAndPassword";
    public const LOGIN_AND_PASSWORD_HASH = "LoginAndPasswordHash";
    public const TICKET = "Ticket";
    public const CERTIFICATE = "Certificate";
    public const CERTIFICATE_WITH_CREDENTIALS = "CertificateWithCredentials";
}
