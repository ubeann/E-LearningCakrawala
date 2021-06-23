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
        'room_id',
        'name',
        'type',
        'release',
        'deadline',
        'description',
    ];

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function submission() {
        return $this->hasMany(Submission::class);
    }

    public function grade() {
        return $this->hasMany(Grade::class);
    }
}
