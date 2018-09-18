<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserStatusMaster;
use Validator;
use Session;
use App\Models\SmsApiSetting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $dataInfo = SmsApiSetting::find(1);
		return view('admin.setting.show',compact('dataInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
		$dataInfo = SmsApiSetting::find(1);
		return view('admin.setting.edit',compact('dataInfo'));
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
		$dataInfo = SmsApiSetting::find(1);
		
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:50',
			'password' => 'required|max:50',
			'sender_id' => 'required|max:50',
			//'url' => 'required|max:255',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
			
			$dataInfo->username = $request->username;
			$dataInfo->password = $request->password;
			$dataInfo->sender_id = $request->sender_id;
			//$dataInfo->url = $request->url;
			if($dataInfo->save()){
				Session::flash('success_message','Settings updated successfully');
				return redirect()->route('admin.settings.sms-api');
			}
			else{
				Session::flash('error_message','Sorry!, unable to settings');    
			}
        }
    }
}
