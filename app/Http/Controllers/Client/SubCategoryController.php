<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Session;
use Storage;
use Validator;
use Auth;
use App\Models\CategoryBanner;
use App\Models\ProductBanner;

class SubCategoryController extends Controller
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
        //$categories = Category::paginate(config('app.customVars.adminPaginationSize'));
		$categories = Category::where('parent','>','0')->where('client_id',$this->clientId)->get();
        return view('client.sub-category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = Category::where('parent','0')->where('client_id',$this->clientId)->get();
        return view('client.sub-category.create',compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$validator = Validator::make($request->all(), [

			'parent' => 'required',
            'name' => 'required|max:100',
			'image' => 'required|mimes:jpeg,jpg,png|max:1000',
			'description' => 'required',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

		$formData = $request->input();
		
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

        return redirect()->route('client.sub-categories');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoryInfo = Category::where('client_id',$this->clientId)->findorfail($id);
		return view('client.sub-category.show',compact('categoryInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('client_id',$this->clientId)->findorfail($id);
        $parentCategories = Category::where('parent','0')->where('client_id',$this->clientId)->get();
        return view('client.sub-category.edit',compact('category','parentCategories'));
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
		    $formData = $request->all();
       
		
        $categoryInfo = Category::where('client_id',$this->clientId)->findorfail($id);
		
        $validator = Validator::make($formData, [
			'parent' => 'required',
            'name' => 'required|max:100',
			'description' => 'required',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
			
			
                  if($request->hasFile('image')){
                  $file = $request->file('image');
                  $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                  $filename = $file->getClientOriginalName();
                  $name = $timestamp . '-' . $filename;
                  if($file->move('public/storage/uploads/category_images', $name)){
                   $categoryInfo->image = $name;
                   
                  }
                }




                $categoryInfo->parent = $formData['parent'];
      $categoryInfo->description = $formData['description'];
      $categoryInfo->status = $formData['status'];
      if($categoryInfo->save()){
       
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
                                'category_id' => $categoryInfo->id,
                                'image' => $name,
                            ]);
               }
                    }
			

}

				Session::flash('success_message','Data updated successfully');
				return redirect()->route('client.sub-categories');
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
        $categoryInfo = Category::where('client_id',$this->clientId)->findorfail($id);
        if($categoryInfo->delete()){
			
			// Deleting the old existing image if exists.
			if($categoryInfo->image!=""){

				Storage::disk('public')->delete('uploads/category_images/'.$categoryInfo->image);
			}
            Session::flash('success_message','Data deleted successfully');

            return redirect()->route('client.sub-categories');
        }
    }
	

	/**
     * Get the listing of sub categories using ajax
     *
     *
     */
    public function getSubCategoriesJSON($parentId)
    {
    	//$client_id=Auth::user()->id;
		$categories = Category::where('parent','>','0')->where('parent',$parentId)->where('client_id',$this->clientId)->get();
		$this->jsonResponse['success'] = true;
		$this->jsonResponse['data'] = $categories;
		return response()->json($this->jsonResponse);
    }
    public function getCategoriesJSON($id)
    {
        $data = Category::where('client_id',$id)->get();
       // dd($data);
        $this->jsonResponse['success'] = true;
		$this->jsonResponse['data'] = $data;
		return response()->json($this->jsonResponse);
    }
  //    public function getSubCategoriesssJSON($parentId)
  //   {
		// $categories = Category::where('parent','>','0')->where('parent',$parentId)->where('client_id',$this->clientId)->get();
		
		// $this->jsonResponse['success'] = true;
		// $this->jsonResponse['data'] = $categories;
		// return response()->json($this->jsonResponse);
  //   }
}
