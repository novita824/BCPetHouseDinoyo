<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function hasRole($role) {
        switch ($role) {
            case 'admin': return \Auth::user()->isAdmin();
            case 'user': return \Auth::user()->isUser();
        }
        return false;
    }
    public function isAdmin()
    {
        if($this->level == 'admin')
        { 
            return true; 
        } 
        else 
        { 
            return false; 
        }
    }
    public function isUser()
    {
        if($this->level == 'user')
        { 
            return true; 
        } 
        else 
        { 
            return false; 
        }
    }
}
