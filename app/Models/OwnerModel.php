<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OwnerModel extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function attributes()
    {
        return $this->attributes;
    }

    public function user_id()
    {
        return $this->attributes['user_id'];
    }
}