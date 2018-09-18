<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Session;
use Carbon\Carbon;
use Storage;
use Validator;
use Auth;
use App\Models\CategoryBanner;
use App\Models\ProductBanner;
use Log;
use DB;

class CategoryController extends Controller
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
        //DB::enableQueryLog();
         /// DB::table()all();
        //$log=DB::getQueryLog();
       // dd($log);
        $categories = Category::where('parent',0)->where('client_id',$this->clientId)->get();
        return view('client.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$parentCategories = Category::where('parent',0)->where('client_id',$this->clientId)->get();
        return view('client.category.create',compact('parentCategories'));
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
		//dd($formData);
		$validator = Validator::make($formData, [
            'name' => 'required|max:100',
			'image' => 'required|mimes:jpeg,jpg,png|max:1000',
			'description' => 'required',
        ]);
		/*
		$validator->after(function ($validator) use($formData) {
			$clientCategory = Category::where('client_id',Auth::user()->id)->where('name',$formData['name'])->get();
			if ($clientCategory) {
				$validator->errors()->add('name', 'Category already exists');
			}
		});
		*/
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		
		// Check if image selected and uploaded

              if($request->hasFile('image')){
                  $file = $request->file('image');
                  $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                  $filename = $file->getClientOriginalName();
                  $name = $timestamp . '-' . $filename;
                  if($file->move('public/storage/uploads/category_images', $name)){
                   $formData['image'] = $name;
                   
                  }
                }






		//dd($formData);
		$formData['client_id'] = $this->clientId;
        $dataInfo = Category::create($formData);
		if($dataInfo){
			
			// Upload banners if selected
                $banners=$request->input('banners');
                if($request->hasfile('banners')){
                    foreach($request->banners as $key => $banner) {
                    $file= $request->file('banners');
                   
                  $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                  $filename = $file[$key]->getClientOriginalName();
                  $name = $timestamp . '-' . $filename;
                  if($file[$key]->move('public/storage/uploads/category_banners', $name)){
                   CategoryBanner::create([
                                'client_id' => $this->clientId,
                                'category_id' => $dataInfo->id,
                                'image' => $name,
                            ]);
               }
                    }



}







			Session::flash('success_message','Data created successfully');
		}
        
        return redirect()->route('client.categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataInfo = Category::where('client_id',$this->clientId)->findorfail($id);
		return view('client.category.show',compact('dataInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataInfo = Category::where('client_id',$this->clientId)->findorfail($id);
        $parentCategories = Category::where([['parent','=','0'],['status','=','1']])->get();
        return view('client.category.edit',compact('dataInfo','parentCategories'));
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
        

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required',
        ]);
        if ($validator->fails()){
               return redirect()->back()->withErrors($validator)->withInput();
            }
    
      
            // if(empty($request->hasFile('banners')))
            // {
            //     Session::flash('success_message','Data updated successfully');
            //     return redirect()->route('client.categories');
            // }
            if((!empty($request->hasFile('image')))|| (!empty($request->hasFile('banners'))))
            {

              if((!empty($request->hasFile('image'))))
               { 

                $dataInfo = Category::where('client_id',$this->clientId)->findorfail($id);
                     $formData = $request->input();
                 if($request->hasFile('image')){
                        $file = $request->file('image');
                        $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                        $filename = $file->getClientOriginalName();
                        $name = $timestamp . '-' . $filename;
                  if($file->move('public/storage/uploads/category_images', $name)){
                           $imageToBeDeleted = $dataInfo->image;
                           $dataInfo->image = $name;
                   
                     }
                }
                $dataInfo->name = $request->name;
                $dataInfo->description = $request->description;
                $dataInfo->status = $request->status;
                $dataInfo->save();


                }



                   $banners=$request->input('banners');

                  
                  if($request->hasfile('banners')){

                  foreach($request->banners as $key => $banner) {
                              $file= $request->file('banners');
                             
                            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                            $filename = $file[$key]->getClientOriginalName();
                            $name = $timestamp . '-' . $filename;
                            if($file[$key]->move('public/storage/uploads/category_banners', $name)){
                             CategoryBanner::create([
                                          'client_id' => $this->clientId,
                                          'category_id' => $id,
                                          'image' => $name,
                                      ]);
                  
                      }
                    } 
            }

      }
        Session::flash('success_message','Data updated successfully');
        return redirect()->route('client.categories');
    }
     
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function destroy($id)
    {
        $dataInfo = Category::where('client_id',$this->clientId)->findorfail($id);
        if($dataInfo->delete()){
			
			// Deleting the old existing image if exists.
			if($dataInfo->image!=""){
				Storage::disk('public')->delete('uploads/category_images/'.$dataInfo->image);
			}
            $bannerInfo=CategoryBanner::where('category_id',$id)->where('client_id',$this->clientId)->get();
            dd($bannerInfo);
             if($bannerInfo->image!=""){
                Storage::disk('public')->delete('uploads/category_banners/'.$bannerInfo->image);
            Session::flash('success_message','Data deleted successfully');
            return redirect()->view('client.category.index');
        }
    }



    }
 
    public function getCategoriesJSON($parentId)
    {
    	//$client_id=Auth::user()->id;
		$categories = Category::where('parent','>','0')->where('parent',$parentId)->where('client_id',$this->clientId)->get();
		$this->jsonResponse['success'] = true;
		$this->jsonResponse['data'] = $categories;
		return response()->json($this->jsonResponse);
    }
}
