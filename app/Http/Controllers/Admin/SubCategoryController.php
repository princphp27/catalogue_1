<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use Carbon\Carbon;
use Session;
use Auth;
use Storage;
use Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $Clients = Client::get(['name']);
       
        $id= Auth::user()->id;
        $categories = Category::where('parent','>','0')->get();
        return view('admin.sub-category.index',compact('categories','Clients','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        // 
        $Clients = Client::all();
        $id= Auth::user()->id;
        $parentCategories = Category::where([['parent','=','0'],['status','=','1']])->get();
       // $master=Category::get(['master']);
        
        // dd($client);
        return view('admin.sub-category.create',compact('parentCategories','Clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {    
         $formData = $request->input();
       //dd($formData);
        $validator = Validator::make($request->all(), [
            'client_id'=> 'required',
            'parent' => 'required',
            'name' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png|max:1000',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

  //       $formData = $request->input('client_id');
        // $formData = $request->input('parent');
  //       $formData = $request->input('name');

        //dd($formData);
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

        return redirect()->route('admin.sub-categories');

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
        return view('admin.sub-category.show',compact('categoryInfo'));
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
        return view('admin.sub-category.edit',compact('category','parentCategories'));
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
        //dd($categoryInfo);
        $validator = Validator::make($request->all(), [

            'parent' => 'required',
            'name' => 'required|max:255',
        ]);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            
            $formData = $request->input();
            $imageToBeDeleted = '';
            
            // Check if image selected and uploaded
            if($request->hasFile('image')){
          $file = $request->file('image');
          $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
          $filename = $file->getClientOriginalName();
          $name = $timestamp . '-' . $filename;
          if($file->move('public/storage/uploads/category_images', $name)){
                    $imageToBeDeleted = $categoryInfo->image;
                    $categoryInfo->image = $name;
                }
            }

            $categoryInfo->name = $request->name;
            $categoryInfo->status = $request->status;
            if($categoryInfo->save()){
                // Deleting the old existing image if exists.
                if($imageToBeDeleted!=""){
                    Storage::disk('public')->delete('uploads/category_images/'.$imageToBeDeleted);
                }
                Session::flash('success_message','Data updated successfully');
                return redirect()->route('admin.sub-categories');
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
        if($categoryInfo->delete())
            
            // Deleting the old existing image if exists.
            if($categoryInfo->image!=""){

                Storage::disk('public')->delete('uploads/category_images/'.$categoryInfo->image);
            }
            Session::flash('error_message','Data deleted successfully');

            return redirect()->route('admin.sub-categories');
        }

    public function getCategoriesJSON($id)
    {
        $data = Category::where('parent',0)->where('client_id',$id)->get();
        //dd($data);
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['data'] = $data;
        return response()->json($this->jsonResponse);
    }
    public function getSubCategoriesJSON($id)
    {
        $data = Category::where('id',$id)->get();
        $this->jsonResponse['success'] = true;
        $this->jsonResponse['data'] = $data;
        return response()->json($this->jsonResponse);
    }
}

