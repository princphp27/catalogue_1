<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Admin;
use Session;

class AuthController extends Controller
{
	
	/**
    * 
    *
    * 
    */
    public function __construct()
    {
		//dd(Auth::user());
        $this->middleware('guest:admin')->except('getLogout');
    }
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function index(){
		
	}
	/**
    * 
    *
    * 
    */
	function getLogin(){
		return view('admin.auth.login');
	}
	/**
    * 
    *
    * 
    */
	function postLogin(Request $request){
		$postData = $request->all();

		$validator = Validator::make($postData, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
		if ($validator->fails()){
			return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
			//dd($postData);
			$email = $postData['email'];
			$password = $postData['password'];
			
			if(Auth::guard('admin')->attempt(array('email' => $email, 'password' => $password, 'status' => '1'))){
				return redirect()->route('admin.dashboard');
			}
			else{
				Session::flash('error_message','Invalid credential');   
				return redirect()->back()->withInput();	
			}
		}
	}
	
	/**
    * 
    *
    * 
    */
	function getLogout(){
		Auth::guard('admin')->logout();
		return redirect()->route('admin.login');
	}
}
