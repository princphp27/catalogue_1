<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','name', 'image', 'parent','description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      
    ];
	
	public function getStatus(){
		return $this->belongsTo('App\Models\StatusMaster','status','id');
	}
	
	public function getParentCategory(){
		return $this->belongsTo('App\Models\Category','parent','id');
	}
	
	public function getBanners(){
		return $this->hasMany('App\Models\CategoryBanner','category_id','id');
	}
    public function getClient(){
        return $this->hasOne('App\Models\Client','id','client_id');
    }
    public function getCategory(){
        return $this->hasOne('App\Models\Product','id','category_id');
    }
     public function getSubCategory(){
        return $this->hasOne(Category::class,'id');
    }
}
