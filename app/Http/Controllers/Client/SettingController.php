<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Storage;
use Validator;
use Auth;
use App\Models\Theme;

class SettingController extends Controller
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
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
	
	public function getTheme(){
		$dataInfo = Theme::where('client_id',$this->clientId)->get()->first();
		return view('client.setting.theme-show',compact('dataInfo'));
	}
	public function editTheme(){
		$dataInfo = Theme::where('client_id',$this->clientId)->get()->first();
		return view('client.setting.theme-edit',compact('dataInfo'));
	}
	public function updateTheme(Request $request){
		
		$dataInfo = Theme::where('client_id',$this->clientId)->get()->first();
		
		$formData = $request->all();
        $validator = Validator::make($formData, [
			'color_code' => 'required',
        ]);
		if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
		else{
		
			if(!$dataInfo){
				$dataInfo = new Theme();
				$dataInfo->client_id = $this->clientId;
			}
			$dataInfo->color_code = $formData['color_code'];
			if($dataInfo->save()){

				Session::flash('success_message','Data updated successfully');
				return redirect()->route('client.theme');
			}
			else{
				Session::flash('error_message','Sorry!, unable to update data');    
			}
        }
	}
}
