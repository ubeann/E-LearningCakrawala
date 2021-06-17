<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nis',
        'room',
        'name',
        'gender',
        'birthday',
        'address',
        'photo',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function grade() {
        return $this->hasMany(Room::class);
    }
    
    public function submission() {
        return $this->hasMany(Submission::class);
    }
}
