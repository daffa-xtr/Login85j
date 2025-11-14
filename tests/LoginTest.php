<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testLoginBerhasil()
    {
        $password = "admin123";
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->assertTrue(password_verify($password, $hash));
    }

    public function testLoginGagalPasswordSalah()
    {
        $password = "admin123";
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $this->assertFalse(password_verify("salah", $hash));
    }
}
