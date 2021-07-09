<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanceoffTeam extends Model
{
    use HasFactory;
    protected $table = "danceoff_teams";
    protected $fillable = ["danceoff_id", "contestant_one_id", "contestant_two_id", "winner"];

    public function contestantOne()
    {
        return $this->belongsTo(Robot::class, 'contestant_one_id');
    }

    public function contestantTwo()
    {
        return $this->belongsTo(Robot::class, 'contestant_two_id');
    }

    public function winner()
    {
        return $this->belongsTo(Robot::class, 'winner');
    }

    public function danceoff()
    {
        return $this->belongsTo(Danceoff::class, 'danceoff_id');
    }
}
