<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Manager;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RobotManagementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testRobotCreationSuccess()
    {
        $manager = Manager::factory()->create();
        $token = JWTAuth::fromUser($manager);
        $teamData = [
            "name" => $this->faker->name(),
            "powermove" => "Diving",
            "experience" => rand(0, 10),
            "outOfOrder" => false,
            "avatar" => "https://robohash.org/samsong.png",
            "manager_id" => $manager->id
        ];

        $response = $this->postJson("api/robots", $teamData, [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "authorization" => "bearer $token"
        ]);
        $response->assertStatus(201)
            ->assertJson([
                "status" => "success",
                "message" => "Robot created successfully",
            ]);
    }
}
