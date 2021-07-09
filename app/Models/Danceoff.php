<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danceoff extends Model
{
    use HasFactory;

    protected $fillable = ["team_one", "team_two"];

    public function teamOne()
    {
        return $this->belongsTo(Team::class, "team_one");
    }

    public function teamTwo()
    {
        return $this->belongsTo(Team::class, "team_two");
    }
}
