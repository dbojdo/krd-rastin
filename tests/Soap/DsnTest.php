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
        $dsn = Dsn::parse("demo://some-login:some-password@default");
        $this->assertEquals("demo", $dsn->env());
        $this->assertEquals("some-login", $dsn->login());
        $this->assertEquals("some-password", $dsn->password());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnInvalidEnv(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Dsn::parse("unknown-env://some-login:some-password@default");
    }
}
