<?php

use Faker\Factory;
use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
    private string $baseUrl = 'http://nginx';

    private $faker;

    protected function setUp(): void
    {
        $this->faker = Factory::create('es_ES');
    }

    public function test_root_route()
    {
        $ch = curl_init($this->baseUrl.'/');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $this->assertEquals(200, $httpCode);
        $this->assertStringContainsString('<!DOCTYPE html>', $response);
        $this->assertStringContainsString('<title>Bienvenido</title>', $response);
    }

    public function test_register_route()
    {
        $ch = curl_init($this->baseUrl.'/register');

        $data = json_encode([
            'id' => $this->faker->uuid(),
            'name' => $this->faker->firstName().' '.$this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(8, 16).'A@1',
        ]);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $this->assertEquals(200, $httpCode);
        $this->assertJson($response);
    }
}
