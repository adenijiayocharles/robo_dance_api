<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Manager;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testTeamCreationAuthenticationFailure()
    {
        $manager = Manager::factory()->create();
        $token = JWTAuth::fromUser($manager);
        $teamData = ["name" => "Ytyuds"];

        $response = $this->postJson("api/teams", $teamData, [
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ]);
        $response->assertStatus(401)
            ->assertJson([
                "message" => "Authorization token not found",
            ]);
    }

    public function testTeamCreationSuccess()
    {
        $manager = Manager::factory()->create();
        $token = JWTAuth::fromUser($manager);
        $teamData = [
            "name" => "Ytyuds",
        ];

        $response = $this->postJson("api/teams", $teamData, [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "authorization" => "bearer $token"
        ]);
        $response->assertStatus(201)
            ->assertJson([
                "status" => "success",
                "message" => "Team created successfully",
            ]);
    }
}
