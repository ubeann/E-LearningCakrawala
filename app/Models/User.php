<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function student() {
        return $this->hasOne(Student::class);
    }
    
    public function employee() {
        return $this->hasOne(Employee::class);
    }

    // public function room() {
    //     return $this->hasOneThrough(
    //         Room::class,
    //         Employee::class,
    //         'nip',
    //         'teacher_id',
    //     );
    // }

    // public function lesson() {
    //     return $this->hasManyThrough(
    //         Room::class,
    //         Employee::class,
    //         'nip',
    //         'teacher_id',
    //     );
    // }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
