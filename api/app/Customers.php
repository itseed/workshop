<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


use Tymon\JWTAuth\Contracts\JWTSubject;

class Customers extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'customers';
    protected $fillable = [
        'id', 'fullname', 'phone_number', 'email', 'uid', 'displayName', 'pictureUrl', 'statusMessage', 'created_at', 'updated_at'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password'];
}