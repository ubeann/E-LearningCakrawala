<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nis',
        'assignment_id',
        'description',
        'file',
    ];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function student() {
        return $this->belongsTo(Student::class, 'nis', 'nis');
    }
}
