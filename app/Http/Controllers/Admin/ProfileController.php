<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use Validator;
use Session;
use Hash;
use Storage;
use App\Models\Admin;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$userInfo = Admin::find(Auth::user()->id);
        return view('admin.profile.index',compact('userInfo'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
		$userInfo = Admin::find(Auth::guard('admin')->user()->id);
		return view('admin.profile.edit',compact('userInfo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$userInfo = Admin::find(Auth::guard('admin')->user()->id);
		
		if(!$userInfo){
			Session::flash('error_message','Invalid profile');
			return redirect()->route('admin.profile');
		}
		
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
			'email' => 'required|unique:admins,email,'.$userInfo->id.'|max:100',
			'profile_image' => 'mimes:jpeg,jpg,png|max:1000',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{

			// Check if profile image selected and uploaded

if($request->hasFile('profile_image')){
          $file = $request->file('profile_image');
          $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
          $filename = $file->getClientOriginalName();
          $name = $timestamp . '-' . $filename;
          if($file->move('public/storage/uploads/user_images', $name)){
            $imageToBeDeleted = $userInfo->profile_image;
           $userInfo->profile_image = $name;
          }
        }
			$userInfo->first_name = $request->first_name;
			$userInfo->last_name = $request->last_name;
			if($userInfo->save()){

				// Deleting the old existing profile image if exists.
				if(isset($imageToBeDeleted) && $imageToBeDeleted!=""){
					Storage::disk('public')->delete('uploads/user_images/'.$imageToBeDeleted);
				}
				
				Session::flash('success_message','Profile updated successfully');
				return redirect()->route('admin.profile');
			}
			else{
				Session::flash('error_message','Sorry!, unable to update profile');    
			}
        }
    }
	public function changePassword()
    {
		//echo "changePassword";exit;
		return view('admin.profile.change-password');
    }
	
	public function updatePassword(Request $request)
    {
		$userInfo = Admin::find(Auth::guard('admin')->user()->id);
		
		if(!$userInfo){
			Session::flash('error_message','Invalid profile');
			return redirect()->route('admin.profile');
		}
		
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|max:20|confirmed',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
		
			if (!Hash::check($request->old_password,$userInfo->password)) {
				return redirect()->back()->withErrors('Your old password does not match');
			}
			
			$newPassword = bcrypt($request->password);
			$userInfo->password = $newPassword;
			if($userInfo->save()){
				Session::flash('success_message','Password changed successfully');
				return redirect()->route('admin.profile.change-password');
			}
			else{
				Session::flash('error_message','Sorry!, unable to change password');    
			}
        }
    }
}
