<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserStatusMaster;
use Validator;
use Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users=User::paginate(config('app.customVars.adminPaginationSize'));

        $users=User::where('type',3)->get();

        return view('admin.customer.index',compact('users'));
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
		return view('admin.customer.show',compact('userInfo'));
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
		return view('admin.customer.edit',compact('userInfo','userStatusMasters'));
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
			'mobile' => 'required|unique:users,mobile,'.$userInfo->id.'|max:15',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
			$userInfo->mobile = $request->mobile;
			$userInfo->status = $request->status;
			if($userInfo->save()){
				Session::flash('success_message','Customer updated successfully');
				return redirect()->route('admin.customers');
			}
			else{
				Session::flash('error_message','Sorry!, unable to update customer');    
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
