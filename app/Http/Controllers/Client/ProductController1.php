<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Validator;
use Session;
use App\Models\ProductImage;
use Storage;
use App\Models\ProductBanner;
use App\Models\ProductSpecification;
use App\Models\ProductPrice;
use Auth;

class ProductController extends Controller
{
	
	private $clientId;
	
	public function __construct(){
		
		$this->middleware(function ($request, $next) {
			$this->clientId = Auth::user()->getClient->id;
			return $next($request);
		});
	}
	
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	//$getCategory=Category::all();
    	// dd($getCategory);
		$dataList = Product::where('client_id',$this->clientId)->get();
		  //dd($dataList);
        return view('client.product.index',compact('dataList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $getCategory=Category::all();
         $parentCategories = Category::where('parent',0)->where('client_id',$this->clientId)->get();
         //dd($parentCategory);
         //$subCategory=Category::where('parent','>',0)->where('client_id',$this->clientId)->get();
         
         return view('client.product.create',compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
    	
		$formData = $request->all();
		//dd($this->clientId);
        $validator = Validator::make($formData, [
			'parent_category' => 'required',
			'category_id' => 'required',
            'name' => 'required|max:100',
			'price' => 'required',
			'description' => 'required',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{

			$formData['client_id'] = $this->clientId;
			
			$dataInfo = Product::create($formData);
			if($dataInfo){
				
				// Insert/Update product price
				ProductPrice::create(['client_id'=>$this->clientId,'product_id'=>$dataInfo->id,'product_price'=>$formData['price'],'status'=>1]);
				
				
				// Insert product specifications
				if(isset($formData['specifications_keys']) && count($formData['specifications_keys'])>0){
					for($i=0;$i<count($formData['specifications_keys']); $i++){
						$key = $formData['specifications_keys'][$i];
						$value = $formData['specifications_values'][$i];
						ProductSpecification::create(['client_id'=>$this->clientId,'product_id'=>$dataInfo->id,'product_key'=>$key,'product_value'=>$value]);
					}
				}
				
				// Upload images if selected
				if($request->hasfile('images')){
					foreach($request->images as $image) {
						$extension = $image->getClientOriginalExtension(); // getting image extension
						$fileName =str_random(60).'.'.$extension;
						if(Storage::disk('public')->put('uploads/product_images/'.$fileName,file_get_contents($image->getRealPath()))){
							ProductImage::create([
								'client_id' => $this->clientId,
								'product_id' => $dataInfo->id,
								'image' => $fileName
							]);
						}
					}
				}
				
				// Upload banners if selected
				if($request->hasfile('banners')){
					foreach($request->banners as $banner) {
						$extension = $banner->getClientOriginalExtension();
						$fileName =str_random(60).'.'.$extension;
						if(Storage::disk('public')->put('uploads/product_banners/'.$fileName,file_get_contents($banner->getRealPath()))){
							ProductBanner::create([
								'client_id' => $this->clientId,
								'product_id' => $dataInfo->id,
								'image' => $fileName
							]);
						}
					}
				}
				
				Session::flash('success_message','Data created successfully');
			}
		}	
        return redirect()->route('client.products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataInfo = Product::where('client_id',$this->clientId)->findorfail($id);
		return view('client.product.show',compact('dataInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    	$categories=Category::where('parent',0)->where('client_id',$this->clientId)->get();
        //dd($categories);
        $dataInfo = Product::where('client_id',$this->clientId)->findorfail($id);
       // dd($dataInfo);
		return view('client.product.edit',compact('dataInfo','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataInfo = Product::where('client_id',$this->clientId)->findorfail($id);
		
		$formData = $request->all();
		//dd($formData);
        $validator = Validator::make($formData, [
			'parent_category' => 'required',
			'category_id' => 'required',
            'name' => 'required|max:100',
            'price' => 'required|numeric',
			'description' => 'required',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
			
			$dataInfo->category_id = $formData['category_id'];
			$dataInfo->name = $formData['name'];
			$dataInfo->description = $formData['description'];
			$dataInfo->status = $formData['status'];
			if($dataInfo->save()){

				// Insert/Update product price
				ProductPrice::where('client_id',$this->clientId)->where('product_id',$dataInfo->id)->update(['status'=>0]);
				ProductPrice::create(['client_id'=>$this->clientId,'product_id'=>$dataInfo->id,'product_price'=>$formData['price'],'status'=>1]);
				
				// Delete all existing specifications
				ProductSpecification::where('client_id',$this->clientId)->where('product_id',$dataInfo->id)->delete();
				
				// Insert product specifications
				if(isset($formData['specifications_keys']) && count($formData['specifications_keys'])>0){
					for($i=0;$i<count($formData['specifications_keys']); $i++){
						$key = $formData['specifications_keys'][$i];
						$value = $formData['specifications_values'][$i];
						ProductSpecification::create(['client_id'=>$this->clientId,'product_id'=>$dataInfo->id,'product_key'=>$key,'product_value'=>$value]);
					}
				}
				
				// Upload images if selected
				if($request->hasfile('images')){
					foreach($request->images as $image) {
						$extension = $image->getClientOriginalExtension(); // getting image extension
						$fileName =str_random(60).'.'.$extension;
						if(Storage::disk('public')->put('uploads/product_images/'.$fileName,file_get_contents($image->getRealPath()))){
							ProductImage::create([
								'client_id' => $this->clientId,
								'product_id' => $dataInfo->id,
								'image' => $fileName
							]);
						}
					}
				}
				
				// Upload banners if selected
				if($request->hasfile('banners')){
					foreach($request->banners as $banner) {
						$extension = $banner->getClientOriginalExtension();
						$fileName =str_random(60).'.'.$extension;
						if(Storage::disk('public')->put('uploads/product_banners/'.$fileName,file_get_contents($banner->getRealPath()))){
							ProductBanner::create([
								'client_id' => $this->clientId,
								'product_id' => $dataInfo->id,
								'image' => $fileName
							]);
						}
					}
				}
				
				Session::flash('success_message','Data updated successfully');
				return redirect()->route('client.products');
			}
			else{
				Session::flash('error_message','Sorry!, unable to update data');    
			}
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataInfo = Product::where('client_id',$this->clientId)->findorfail($id);
        if($dataInfo->delete()){
			// Deleting the old existing image if exists.
			if($dataInfo->image!=""){
				Storage::disk('public')->delete('uploads/product_images/'.$dataInfo->image);
			}
            Session::flash('error_message','Data deleted successfully');
            return redirect()->route('client.products');
        }
    }
    public function getCategoriesJSON($parentId)
    {
    	$client_id=Auth::user()->id;
		$categories = Category::where('parent','>','0')->where('parent',$parentId)->where('client_id',$this->clientId)->get();
		$this->jsonResponse['success'] = true;
		$this->jsonResponse['data'] = $categories;
		return response()->json($this->jsonResponse);
    }
	
}
