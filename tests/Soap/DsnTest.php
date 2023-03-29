<?php

namespace Goosfraba\KrdRastin\Soap;

use PHPUnit\Framework\TestCase;

class DsnTest extends TestCase
{
    /**
     * @test
     */
    public function itParsesDsn(): void
    {
        $dsn = Dsn::parse("krd+rastin://some-login:some-password@demo");
        $this->assertEquals("demo", $dsn->env());
        $this->assertEquals("some-login", $dsn->login());
        $this->assertEquals("some-password", $dsn->password());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnInvalidScheme(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Dsn::parse("unknown-scheme://some-login:some-password@default");
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnInvalidHost(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Dsn::parse("krd+rastin://some-login:some-password@unknown-host");
    }
}
