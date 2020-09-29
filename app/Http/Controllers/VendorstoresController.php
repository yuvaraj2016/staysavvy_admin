<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VendorstoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Http $client)
    {
      
        $this->client = $client;
    }


    public function index(Request $request,$page = 1)
    {
        //

        $token = session()->get('token');
        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $vendorstores = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

          return view('vendorstores_list', compact('vendorstores', 'pagination','lastpage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token = session()->get('token');

        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confVendorCat');

            $vcresponse = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $vendorcategories = $vcresponse['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $vresponse = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $vendor = $vresponse['data'];



       try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];


            return view(
                'create_vendor_stores', compact(
                    'vendorcategories','statuses','vendor'
                )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $session = session()->get('token');
        $fileext = '';
        $filename = '';
        if ($request->file('file') !== null) {

            $files =$request->file('file');
            $response = Http::withToken($session);
            foreach($files as $k => $ufile)
            {
                $filename = fopen($ufile, 'r');
                $fileext = $ufile->getClientOriginalName();
                $response = $response->attach('file['.$k.']', $filename,$fileext);
            }

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/vendorStores',
            [
            [
                'name' => 'vendor_id',
                'contents' => $request->vendor_id
            ],
            [
                'name' => 'vendor_store_name',
                'contents' => $request->vendor_store_name
            ],
            [
                'name' => 'vendor_store_location',
                'contents' => $request->vendor_store_location
            ],
            [
                'name' => 'vendor_store_address',
                'contents' => $request->vendor_store_address
            ],
            [
                'name' => 'vendor_store_contact',
                'contents' => $request->vendor_store_contact
            ],
            [
                'name' => 'latitude',
                'contents' => $request->latitude
            ],
            [
                'name' => 'longitude',
                'contents' => $request->longitude
            ],
            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ],

            ]);


        }



        else{
            $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/vendorStores', [
                "vendor_id"=>$request->vendor_id,
                "vendor_store_name"=>$request->vendor_store_name,
                "vendor_store_location"=>$request->vendor_store_location,
                "vendor_store_address"=>$request->vendor_store_address,
                "vendor_store_contact"=>$request->vendor_store_contact,
                "latitude"=>$request->latitude,
                "longitude"=>$request->longitude,
                "status_id"=>$request->status_id

            ]);
            // dd($response);
        }

        if($response->status()==201){
            // return redirect()->route('vendors.create')->with('success','Vendor Created Successfully!');
            return redirect()->back()->with('success','Vendor stores Created Successfully!');
        }else{
            $request->flash();

            return redirect()->route('vendorstores.create')->with('error',$response['errors']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $token = session()->get('token');

        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);

        }catch (\Exception $e){



        }
         $vendorstores = $response['data'];



            return view(
                'view_vendor_stores', compact(
                    'vendorstores'
                )
        );
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


        $session = session()->get('token');




        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confVendorCat');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorcat = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $vresponse = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $vendors = $vresponse['data'];


        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         $response=Http::withToken($session)->get(config('global.url').'/api/vendorStores/'.$id);
//return $response;

        if($response->ok()){

            $vendorstores = $response->json()['data'];
         
// return $vendors['id'];
            return view('edit_Vendor_stores', compact(
                'vendorcat','statuses','vendors','vendorstores'
            ));
        }






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



        $session = session()->get('token');
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/vendorStores/'.$id, 
        
        [
            "_method"=> 'PUT',
            "vendor_id"=>$request->vendor_id,
            "vendor_store_name"=>$request->vendor_store_name,
            "vendor_store_location"=>$request->vendor_store_location,
            "vendor_store_address"=>$request->vendor_store_address,
            "vendor_store_contact"=>$request->vendor_store_contact,
            "latitude"=>$request->latitude,
            "longitude"=>$request->longitude,
            "status_id"=>$request->status_id
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Vendor Stores Updated Successfully!');
        }else{
            return redirect()->back()->with('error',$response->json()['message']);
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
        $session = session()->get('token');

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/vendorStores/'.$id);

        if($response->status()==204){

             return redirect()->route('vendorstores.index')->with('success','Vendor Stores Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('vendorstores.index')->with('error',$response->json()['message']);
        }

    }


    public function getallvendorstores()
    {
        $token = session()->get('token');
        
        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

            $vsresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorstores = $vsresponse['data'];

         return $vendorstores;

    }

}
