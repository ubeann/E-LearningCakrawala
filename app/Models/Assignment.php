<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'release',
        'deadline',
        'description',
    ];

    public function lesson() {
        return $this->belongsTo(Lesson::class);
    }

    public function submission() {
        return $this->hasMany(Submission::class);
    }
}
