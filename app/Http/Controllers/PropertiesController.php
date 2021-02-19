<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertiesController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/property?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
         // return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $property = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];
        

          return view('properties_list', compact('property', 'pagination','lastpage'));
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confTax');

            $response = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $tax = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confAmenity');

            $response = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $amenity = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confHostType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $host = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confPropertyType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $property_type = $response['data'];

         

         return view(
            'create_properties', compact(
                'tax','amenity','statuses','host','property_type'
            )
    );

        //    return view('create_property');
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
        $taxes='';
        $amenities='';

        foreach($request->taxes as $tax)
        {

            $taxes .= $tax.",";
        }

        foreach($request->amenities as $amenity)
        {

            $amenities .= $amenity.",";
        }

        $taxes = rtrim($taxes,",");

        $amenities = rtrim($amenities,",");

        // return $amenities;

        if ($request->file('file') !== null) {

            $files =$request->file('file');
            $response = Http::withToken($session);
       

            // return $request->amenities;
            foreach($files as $k => $ufile)
            {
                $filename = fopen($ufile, 'r');
                $fileext = $ufile->getClientOriginalName();
                $response = $response->attach('file['.$k.']', $filename,$fileext);
            }
            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/property',
            [
            [
                'name' => 'name',
                'contents' => $request->name
            ],
            [
                'name' => 'address',
                'contents' => $request->address
            ],
            [
                'name' => 'location',
                'contents' => $request->location
            ],
            [
                'name' => 'host_type_id',
                'contents' => $request->host_type_id
            ],
            [
                'name' => 'property_mgmt_system',
                'contents' => $request->property_mgmt_system
            ],

            [
                'name' => 'central_res_system',
                'contents' => $request->central_res_system
            ],

            [
                'name' => 'property_type_id',
                'contents' => $request->property_type_id
            ],

            [
                'name' => 'general_description',
                'contents' => $request->general_description
            ],
            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ],
            [
                'name' => 'taxes[]',
                'contents' =>$taxes
            ],
            [
                'name' => 'amenities[]',
                'contents' =>$amenities
            ],

            ]);


        }


        else{
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/property',

        [

            "name"=>$request->name,
            "address"=>$request->address,
            "location"=>$request->location,
            "host_type_id"=>$request->host_type_id,
            "property_mgmt_system"=>$request->property_mgmt_system,
            "central_res_system"=>$request->central_res_system,
            "property_type_id"=>$request->property_type_id,
            "general_description"=>$request->general_description,
            "status_id"=>$request->status_id,
            "taxes[]"=>$taxes,
            "amenities[]"=>$amenities
        ]);

        }

        if($response->status()===201){

return $response;
            return redirect()->route('properties.create')->with('success','Properties Type Created Successfully!');
        }else{
            return $response;

            $request->flash();

            return redirect()->route('properties.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/property/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $properties = $response['data'];

// return $properties;

            return view(
                'view_properties_list', compact(
                    'properties'
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
        $session = session()->get('token');


       
        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confTax');

            $response = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $tax = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confAmenity');

            $response = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $amenity = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confHostType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $host = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confPropertyType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $property_type = $response['data'];



        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/property/' . $id);

       
     
        

        if($response->ok()){

            $properties =   $response->json()['data'];

            //  return $properties;

            return view('edit_properties', compact(
               'properties', 'tax','amenity','statuses','host','property_type'
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
        $session = session()->get('token');
        $taxes='';
        $amenities='';

        foreach($request->taxes as $tax)
        {

            $taxes .= $tax.",";
        }

        foreach($request->amenities as $amenity)
        {

            $amenities .= $amenity.",";
        }

        $taxes = rtrim($taxes,",");
        // return  $taxes;
        $amenities = rtrim($amenities,",");
        //  return  $amenities;
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'/api/property/'.$id, 
        
        [
            "_method"=> 'PUT',
                    
            "name"=>$request->name,
            "address"=>$request->address,
            "location"=>$request->location,
            "host_type_id"=>$request->host_type_id,
            "property_mgmt_system"=>$request->property_mgmt_system,
            "central_res_system"=>$request->central_res_system,
            "property_type_id"=>$request->property_type_id,
            "general_description"=>$request->general_description,
            "status_id"=>$request->status_id,
            "taxes"=>$taxes,
            "amenities"=>$amenities
        ]
        
      );
    //   return $response;
        // return $response;
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Properties Updated Successfully!');
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/property/'.$id);

        if($response->status()==204){

             return redirect()->route('properties.index')->with('success','Properties Deleted Sucessfully !..');
        }
        else{


             return redirect()->route('properties.index')->with('error',$response->json()['message']);
        }

    }
}
