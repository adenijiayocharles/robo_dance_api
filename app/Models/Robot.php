<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'manager_id',
        'powermove',
        'experience',
        'outOfOrder',
        'avatar'
    ];

    public function getOutOfOrderAttribute($value)
    {
        return !$value ? false : true;
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
