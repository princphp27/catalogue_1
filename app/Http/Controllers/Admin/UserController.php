<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserStatusMaster;
use Validator;
use Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users=User::paginate(config('app.customVars.adminPaginationSize'));
        $users=User::where('type',1)->get();
        return view('admin.user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo = User::find($id);
		return view('admin.user.show',compact('userInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userInfo = User::find($id);
		$userStatusMasters = UserStatusMaster::all();
		return view('admin.user.edit',compact('userInfo','userStatusMasters'));
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
		$userInfo = User::find($id);
		
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
			'email' => 'required|unique:users,email,'.$userInfo->id.'|max:255',
			'mobile' => 'required|max:15',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{

			
			
			$userInfo->email = $request->email;
			$userInfo->mobile = $request->mobile;
			$userInfo->status = $request->status;
			if($userInfo->save()){
				$userInfo->profile->first_name = $request->first_name;
				$userInfo->profile->last_name = $request->last_name;
				$userInfo->profile->save();
				
				Session::flash('success_message','User updated successfully');
				return redirect()->route('admin.users');
			}
			else{
				Session::flash('error_message','Sorry!, unable to update user');    
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
        //
    }
}
