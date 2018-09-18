<?php
namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Session;
use Carbon\Carbon;
use Storage;
use DB;
use App\Models\Enquiry;
use App\Models\Client;
use DataTables;
class EnquiryController extends Controller
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
        
       return view('client.Enquiry.enquiry');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    public function getdata()
      {
          $enquiry_data=DB::table('enquiries')
            ->join('clients', 'enquiries.client_id', '=', 'clients.id')
            ->join('products', 'enquiries.product_id', '=', 'products.id')
            ->select('enquiries.*', 'clients.name as client_name', 'products.name as product_name')
            ->where('enquiries.client_id',$this->clientId)
            ->get();
          
          return DataTables::of($enquiry_data)->make(true);
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client_id=Auth::user()->getClient->id;
        //dd($client_id);
        $formdata=$request->all();
        $validator=Validator::make($formdata,[

                    'product_id'=>'required|numeric',
                    'subject'=>'required',
                    'message'=>'required',
           ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
          else
          {
             
            $formdata['client_id']=$this->clientId;
             $enquiry_save=Enquiry::create($formdata);
            if($enquiry_save->save())
              Session::flash('success_message','Data created successfully');
             else
                Session::flash('error_message','Data Not successfully');
          }
          
          return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
