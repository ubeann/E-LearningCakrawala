<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'phone',
        'salary',
        'tenure',
        'address',
        'photo',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->hasOne(Room::class);
    }

    public function lesson() {
        return $this->hasMany(Lesson::class);
    }
}
