<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'name',
        'year',
        'description',
        'photo',
    ];

    public function teacher() {
        return $this->belongsTo(Employee::class);
    }

    public function student() {
        return $this->hasMany(Student::class);
    }

    public function assignment() {
        return $this->hasMany(Assignment::class);
    }
}
