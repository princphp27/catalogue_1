<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Category;
use App\Models\UserStatusMaster;
use Validator;
use Session;
use Carbon\Carbon;
use App\User;
//use Client;
use DB;
use Auth;
use Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $dataList = Client::where('is_deleted',0)->get();
        //dd($dataList);
        return view('admin.client.index',compact('dataList'));
    }
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategoriesJSON($id)
    {
        $data = Category::where('client_id',$id)->get();
       // dd($data);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.client.create');
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
		
        $validator = Validator::make($formData, [
            'name' => 'required|max:100',
            'email' => 'required|email|unique:clients,email|max:100',
            'address' => 'required|max:100',
            'phone' => 'required|max:20',
			'logo' => 'mimes:jpeg,jpg,png|max:1000',
			
			'contact_name' => 'required|max:100',
			'contact_email' => 'required|email|max:100',
			'contact_mobile' => 'required|max:100',
			
			'login_email' => 'required|unique:users,email|max:100',
			'password' => 'required|min:6|max:20|confirmed',
        ]);
		// If validation fails
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

		
		if($request->hasFile('logo')){
          $file = $request->file('logo');
          $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
          $filename = $file->getClientOriginalName();
          $name = $timestamp . '-' . $filename;
          if($file->move('public/storage/uploads/user_images', $name)){
           $formData['logo'] = $name;
          }
        }
		// Start the process to create client with its references using transaction
		$success = false;
		DB::beginTransaction();
		try {

			$formData['token'] = str_random(60);
            $formData['client_key']=str_random(60);
		//dd( $formData['client_key']);
			$dataInfo = Client::create($formData);
			$userInfo = User::create([
								'user_type' =>'1',
								'client_id' =>$dataInfo->id,
								'email' => $formData['login_email'],
								'password' => Hash::make($formData['password']),
								'api_token' => str_random(32),
                                'client_key'=>str_random(32),

							]);
			DB::commit();
			$success = true;
			
		} 
		catch (\Exception $e) {
			$success = false;
			DB::rollback();
		}

		if ($success) {
			// the transaction worked ...				
			Session::flash('success_message','Data created successfully');
		}
		else{
			Session::flash('error_message','Sorry!, unable to create data');
		}
		return redirect()->route('admin.clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataInfo = Client::where('is_deleted',0)->findorfail($id);
        $userInfo=User::where('client_id',$id)->first();
        
        return view('admin.client.show',compact('dataInfo','userInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$dataInfo = Client::findorfail($id);
        return view('admin.client.edit',compact('dataInfo'));
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
		$dataInfo = Client::findorfail($id);
		$formData = $request->all();
        $validator = Validator::make($formData, [
			'name' => 'required|max:100',
            'email' => 'required|email|unique:clients,email,'.$dataInfo->id.'|max:100',
            'address' => 'required|max:100',
            'phone' => 'required|max:20',
			'logo' => 'mimes:jpeg,jpg,png|max:1000',
			
			'contact_name' => 'required|max:100',
			'contact_email' => 'required|email|max:100',
			'contact_mobile' => 'required|max:100',
        ]);
		
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{

        if($request->hasFile('logo')){
          $file = $request->file('logo');
          $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
          $filename = $file->getClientOriginalName();
          $name = $timestamp . '-' . $filename;
          if($file->move('public/storage/uploads/user_images', $name)){
            $imageToBeDeleted = $dataInfo->profile_image;
           $dataInfo->logo = $name;
          }
        }





			
			
			$dataInfo->name = $formData['name'];
			$dataInfo->email = $formData['email'];
			$dataInfo->address = $formData['address'];
			$dataInfo->city = $formData['city'];
			$dataInfo->state = $formData['state'];
			$dataInfo->pincode = $formData['pincode'];
			$dataInfo->phone = $formData['phone'];
			$dataInfo->description = $formData['description'];
			$dataInfo->status = $formData['status'];
			$dataInfo->contact_name = $formData['contact_name'];
			$dataInfo->contact_email = $formData['contact_email'];
			$dataInfo->contact_mobile = $formData['contact_mobile'];
			
			if($dataInfo->save()){

				// Deleting the old existing profile image if exists.
				if(isset($imageToBeDeleted) && $imageToBeDeleted!=""){
					Storage::disk('public')->delete('uploads/client_images/'.$imageToBeDeleted);
				}
				Session::flash('success_message','Data updated successfully');
			}
			else{
				Session::flash('error_message','Sorry!, unable to update data');    
			}
        }
		return redirect()->route('admin.clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        
        $data=Client::where('id',$id)->update(['is_deleted'=>1]);
        Session::flash('error_message','client delete successfully!!');
        return back();
    }
}
