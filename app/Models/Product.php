<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id','category_id','name','description','product_main_image',
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
	public function getCategory(){
		return $this->belongsTo('App\Models\Category','category_id','id');
	}
	public function getImages(){
		return $this->hasMany('App\Models\ProductImage','product_id','id');
	}
	public function getBanners(){
		return $this->hasMany('App\Models\ProductBanner','product_id','id');
	}
	public function getSpecifications(){
		return $this->hasMany('App\Models\ProductSpecification','product_id','id');
	}
	public function getPrices(){
		return $this->hasMany('App\Models\ProductPrice','product_id','id');
		}
	//  public function getpCategory(){
	// 	return $this->belongsTo('App\Models\Category','parent','id');
	// }
	 public function getClient(){
        return $this->hasOne('App\Models\Client','id','client_id');
    }
		
}
	

