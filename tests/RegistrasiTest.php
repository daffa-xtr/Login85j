<?php
use PHPUnit\Framework\TestCase;

class RegistrasiTest extends TestCase
{
    public function testHashPasswordBerhasil()
    {
        $password = "testing123";
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($password, $hash));
    }
}
