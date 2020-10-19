<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

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