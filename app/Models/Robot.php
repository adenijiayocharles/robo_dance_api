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

    public function manager()
    {
        return $this->belongsTo('App\Manager');
    }
}
