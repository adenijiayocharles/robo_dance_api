<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RobotTeam extends Model
{
    use HasFactory;
    protected $table = "robot_team";
    protected $fillable = [
        "team_id", "robot_id", "manager_id"
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function robot()
    {
        return $this->belongsTo(Robot::class);
    }
}
