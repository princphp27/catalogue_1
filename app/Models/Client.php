<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token','name','email', 'address', 'city','state','pincode','logo','description','phone','contact_name','contact_mobile','contact_email','client_key',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
	
	public function getStatus(){
		return $this->belongsTo('App\Models\StatusMaster','status','id');
	}
    
}
