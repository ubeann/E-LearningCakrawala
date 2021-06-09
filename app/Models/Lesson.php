<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'kkm',
        'description',
    ];

    public function teacher() {
        return $this->belongsTo(Employee::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function grade() {
        return $this->hasMany(Student::class);
    }

    public function assignment() {
        return $this->hasMany(Assignment::class);
    }
}
