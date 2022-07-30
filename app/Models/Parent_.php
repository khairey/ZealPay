<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Parent_ extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'parents';

    protected $fillable = [
        'name',
        'parent_id',  
    ];

    public function children()
    {
        return $this->hasMany(Parent_::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Parent_::class, 'parent_id');
    }
}
