<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manager_id'
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function robots()
    {
        return $this->belongsToMany(Robot::class);
    }
}
