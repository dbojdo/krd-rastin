<?php

namespace Goosfraba\KrdRastin\Soap;

final class KrdRastinWsdl
{
    private const DEMO_WSDL = "https://demo.krd.pl/Rastin/v2/Verification.svc?singleWsdl";
    private const PROD_WSDL = "https://services.krd.pl/Rastin/v2/Verification.svc?singleWsdl";

    private string $wsdl;

    private function __construct(string $wsdl)
    {
        $this->wsdl = $wsdl;
    }

    public static function demo(): self
    {
        return new self(self::DEMO_WSDL);
    }

    public static function prod(): self
    {
        return new self(self::PROD_WSDL);
    }

    /**
     * Creates a custom WSDL path
     */
    public static function custom(string $wsdl): self
    {
        return new self($wsdl);
    }

    public function __toString(): string
    {
        return $this->wsdl;
    }
}
