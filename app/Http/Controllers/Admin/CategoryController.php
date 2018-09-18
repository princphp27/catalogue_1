<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use Session;
use Carbon\Carbon;
use Storage;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     $Clients=Client::all();
        $categories = Category::where('parent',0)->get();
        return view('admin.category.index',compact('categories','Clients'));
    }
    public function getCategoriesJSON($id)
    {
        $data = Category::where('parent',0)->where('client_id',$id)->get();
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['data'] = $data;
        return response()->json($this->jsonResponse);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $Clients=Client::all();
        $parentCategories = Category::where([['parent','=','0'],['status','=','1']])->get();
        //dd($parentCategories);
        return view('admin.category.create',compact('parentCategories','Clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
           $client=Client::all();

		$formData = $request->all();
		//dd($formData);
		$validator = Validator::make($formData, [

            'name' => 'required|max:100',
			'image' => 'required|mimes:jpeg,jpg,png|max:1000',
			
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
        Category::create($formData);
        Session::flash('success_message','Data created successfully');
        return redirect()->route('admin.categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoryInfo = Category::find($id);
		return view('admin.category.show',compact('categoryInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $parentCategories = Category::where([['parent','=','0'],['status','=','1']])->get();
        return view('admin.category.edit',compact('category','parentCategories'));
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
        $categoryInfo = Category::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
		if ($validator->fails()){
           return redirect()->back()->withErrors($validator)->withInput(); 
        }
		else{
			
			$formData = $request->input();
			//$imageToBeDeleted = '';
			
			// Check if image selected and uploaded
			        if($request->hasFile('image')){
                        // dd($request->hasFile('image'));
                  $file = $request->file('image');
                  $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                  $filename = $file->getClientOriginalName();
                  $name = $timestamp . '-' . $filename;
                  if($file->move('public/storage/uploads/category_images', $name)){
                   $formData['image'] = $name;
                   $categoryInfo->image=$formData['image'];
                  }
                }
			$categoryInfo->name = $request->name;
			$categoryInfo->status = $request->status;
			if($categoryInfo->save()){
				// Deleting the old existing image if exists.
				
				Session::flash('success_message','Data updated successfully');
				return redirect()->route('admin.categories');
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
        $categoryInfo = Category::find($id);
        if($categoryInfo->delete()){
			
			// Deleting the old existing image if exists.
			if($categoryInfo->image!=""){
				Storage::disk('public')->delete('uploads/category_images/'.$categoryInfo->image);
			}

             $bannerInfo=CategoryBanner::where('category_id',$id)->get();
             if($bannerInfo->image!=""){
                Storage::disk('public')->delete('uploads/category_banners/'.$bannerInfo->image);
            }
             Session::flash('error_message','Data deleted successfully');
             return redirect()->route('admin.categories');
        }
    }
   
    
}
