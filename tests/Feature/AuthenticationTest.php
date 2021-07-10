<?php

namespace Tests\Feature;

use App\Models\Manager;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Tests the required field on the manager registration endpoint
     *
     * @return  void
     */
    public function testingManagerSignupRequiredField()
    {
        $response = $this->postJson("api/auth/register", ["Accept" => "application/json", "Content-Type" => "application/json"]);
        $response->assertStatus(422)->assertJson([
            "message" => "The given data was invalid.",
            "errors" => [
                "name" => ["The name field is required."],
                "email" => ["The email field is required."],
                "password" => ["The password field is required."],
            ]
        ]);
    }

    /**
     * Tests the password confirmation feature on the manager registration endpoint
     *
     * @return  void
     */
    public function testRepeatPasswordFail()
    {
        $data = [
            "name" => $this->faker->firstName() . " " . $this->faker->lastName(),
            "email" => $this->faker->email(),
            "password" => Hash::make($this->faker->password()),
        ];

        $response = $this->postJson("api/auth/register", $data, [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ]);
        $response->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "password" => ["The passwords do not match"]
                ]
            ]);
    }

    /**
     * Tests successfull manager registration
     *
     * @return  [void
     */
    public function testingManagerSignupPassed()
    {
        $password = bcrypt("password");
        $response = $this->postJson(
            "api/auth/register",
            [
                "name" => "John Doe",
                "email" => "johndoe@yahoo.com",
                "password" => $password,
                "password_confirmation" => $password
            ],
            [
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]
        );
        $response->assertStatus(201)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "manager", "auth_token"
                ]
            ]);
    }

    public function testingManagerLoginFailed()
    {
        $data = [
            "email" => "johndoe@gmail.com",
            "password" => bcrypt("passwsord"),
        ];

        $response = $this->postJson("api/auth/login", $data, [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ]);
        $response->assertStatus(400)
            ->assertJson([
                "status" => "error",
                "message" => "Invalid credentials",
                "errors" => []
            ]);
    }

    public function testingManagerLoginSuccess()
    {
        Manager::factory()->create([
            "name" => "John Doe",
            "email" => "johndoe@gmail.com",
            "password" => "password"
        ]);


        $loginData = [
            "email" => "johndoe@gmail.com",
            "password" => "password"
        ];

        $this->postJson("api/auth/login", $loginData, ["Accept" => "application/json", "Content-Type" => "application/json"])
            ->assertStatus(200);
        $this->assertAuthenticated();
    }
}
