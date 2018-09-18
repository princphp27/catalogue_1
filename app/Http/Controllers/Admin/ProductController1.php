<?php
namespace App\Http\Controllers\Admin;
//namespace App;
//use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Product;
// use App\Models\ProductPrice;
use App\Models\Category;
use Validator;
use Session;
use App\Models\ProductImage;
use Storage;
use App\Models\ProductBanner;
use App\Models\Client;
use App\Models\ProductSpecification;
use App\Models\ProductPrice;


class ProductController extends Controller
{   
    // private $clientId;
    
    // public function __construct(){
        
    //     $this->middleware(function ($request, $next) {
    //         $this->clientId = Auth::user()->id;
    //         return $next($request);
    //     });
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data=Auth::user()->all();
        // dd($data);
        $id=Auth::user()->id;
        $getCategory=Category::all();
        $dataList = Product::all();
          ///dd($dataList);
        return view('admin.product.index',compact('dataList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $id=Auth::user()->id;
        $clientName=Client::all();
        $category=Category::all();
       $subCategories=Category::where('parent','>','0')->where('client_id',$id)->get();
       // dd($subCategories);
        return view('admin.product.create',compact('clientName','category','subCategories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $id=$request->input('client');
        $formData = $request->all();
       // dd($formData);
        $validator = Validator::make($formData, [
            'parent' => 'required',
            'category_id' => 'required',
            'name' => 'required|max:100',
            'price' => 'required|numeric',
            'description' => 'required',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{

            $formData['client_id'] = $id;
            
            $dataInfo = Product::create($formData);
            if($dataInfo){
                
                // Insert/Update product price
                ProductPrice::create(['client_id'=>$id,'product_id'=>$dataInfo->id,'product_price'=>$formData['price'],'status'=>1]);
                
                
                // Insert product specifications
                if(isset($formData['specifications_keys']) && count($formData['specifications_keys'])>0){
                    for($i=0;$i<count($formData['specifications_keys']); $i++){
                        $key = $formData['specifications_keys'][$i];
                        $value = $formData['specifications_values'][$i];
                        ProductSpecification::create(['client_id'=>$id,'product_id'=>$dataInfo->id,'product_key'=>$key,'product_value'=>$value]);
                    }
                }
                
                // Upload images if selected
                if($request->hasfile('images')){
                    foreach($request->images as $image) {
                        $extension = $image->getClientOriginalExtension(); // getting image extension
                        $fileName =str_random(60).'.'.$extension;
                        if(Storage::disk('public')->put('uploads/product_images/'.$fileName,file_get_contents($image->getRealPath()))){
                            ProductImage::create([
                                'client_id' => $id,
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
                                'client_id' => $id,
                                'product_id' => $dataInfo->id,
                                'image' => $fileName
                            ]);
                        }
                    }
                }
                
                Session::flash('success_message','Data created successfully');
            }
        }   
        return redirect()->route('admin.products');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataInfoo=Product::where('id',$id)->get();
        return view('admin.product.show',compact('dataInfoo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=category::where('parent','0')->get();
       $dataInfoo = Product::where('id',$id)->get();
       // dd($dataInfoo);
        return view('admin.product.edit',compact('dataInfoo','data'));
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
        
        $dataInfo = Product::where('id',$id)->first();

        $user = Product::where('id',$id)->first();
        $clientId=$user->client_id;
        //dd($clientId);
        $formData = $request->all();
        //dd($formData);
        $validator = Validator::make($formData, [
            'parent' => 'required',
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
            
                //return redirect()->route('admin.products');
               if($dataInfo->save()){
          
                // Insert/Update product price
                ProductPrice::where('client_id',$clientId)->where('product_id',$dataInfo->id)->update(['status'=>0]);
                ProductPrice::create(['client_id'=>$clientId,'product_id'=>$dataInfo->id,'product_price'=>$formData['price'],'status'=>1]);
                
                // Delete all existing specifications
                ProductSpecification::where('client_id',$clientId)->where('product_id',$dataInfo->id)->delete();
                
                // Insert product specifications
                if(isset($formData['specifications_keys']) && count($formData['specifications_keys'])>0){
                    for($i=0;$i<count($formData['specifications_keys']); $i++){
                        $key = $formData['specifications_keys'][$i];
                        $value = $formData['specifications_values'][$i];
                        ProductSpecification::create(['client_id'=>$clientId,'product_id'=>$dataInfo->id,'product_key'=>$key,'product_value'=>$value]);
                    }
                }
                
                // Upload images if selected
                if($request->hasfile('images')){
                    foreach($request->images as $image) {
                        $extension = $image->getClientOriginalExtension(); // getting image extension
                        $fileName =str_random(60).'.'.$extension;
                        if(Storage::disk('public')->put('uploads/product_images/'.$fileName,file_get_contents($image->getRealPath()))){
                            ProductImage::create([
                                'client_id' => $clientId,
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
                                'client_id' => $clientId,
                                'product_id' => $dataInfo->id,
                                'image' => $fileName
                            ]);
                        }
                    }
                }
                    
                
                Session::flash('success_message','Data updated successfully');
                return redirect()->route('admin.products');
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
        $data=Product::find($id);
        if($data->delete())
             Session::flash('error_message','Data deleted successfully');
         return back();
    }
	public function getCategoriesJSON($id)
    {
    	//$clent_id=Product::where('')
        $data = Category::where('parent','0')->where('client_id',$id)->get();
        
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['data'] = $data;
        return response()->json($this->jsonResponse);
    }
        public function getSubCategoriesJSON($id)
        {
            $product = Category::where('parent','>','0')->where('parent',$id)->get();
          
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['data'] = $product;
        return response()->json($this->jsonResponse);
    }

}
