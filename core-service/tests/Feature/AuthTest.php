<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    // LOGIN:
    /**
     * Should not success when there is not password in the body
     */
    public function test_login_no_password(): void
    {
        $response = $this->post('/api/login', ['email' => 'email@test.dev']);

        $response->assertStatus(400);
    }
    /**
     * Should not success when there is not email in the body
     */
    public function test_login_no_email(): void
    {
        $response = $this->post('/api/login', ['password' => '123456']);

        $response->assertStatus(400);
    }
    /**
     * Should success when using correct credentials
     */
    public function test_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = '123456'),
        ]);
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertStatus(200);
    }
    /**
     * Should not success when not using correct credentials
     */
    public function test_login_with_incorrect_credentials(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = '123456'),
        ]);
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'test',
        ]);
        $response->assertStatus(401);
    }
    // REGISTER:
    /**
     * Should not success when there is not password in the body
     */
    public function test_register_no_password(): void
    {
        $response = $this->post('/api/register', [
            'email' => 'email@test.dev',
            'name' => 'test',
        ]);

        $response->assertStatus(400);
    }
    /**
     * Should not success when there is not name in the body
     */
    public function test_register_no_name(): void
    {
        $response = $this->post('/api/register', [
            'email' => 'email@test.dev',
            'password' => 'test',
        ]);

        $response->assertStatus(400);
    }
    /**
     * Should not success when there is not email in the body
     */
    public function test_register_no_email(): void
    {
        $response = $this->post('/api/register', [
            'password' => '123456',
            'name' => 'test',
        ]);

        $response->assertStatus(400);
    }
    /**
     * Should success when all body properties are valid
     */
    public function test_register_with_correct_props(): void
    {
        $response = $this->post('/api/register', [
            'email' => 'email@test.dev',
            'password' => '123456',
            'name' => 'test',
        ]);

        $response->assertStatus(200);
    }
}
