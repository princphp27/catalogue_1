<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type','client_id','name', 'email', 'password','api_token','client_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token',
    ];
	
	
	
	public function getClient(){
        return $this->belongsTo('App\Models\Client','client_id','id');
		///return $this->hasOne('App\Models\Client','id','client_id');
	}
}
