<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class RoomController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/room?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $room = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];
        

          return view('property_room_list', compact('room', 'pagination','lastpage'));
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/property');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $property = $response['data'];
         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confRoomType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $confRoomType = $response['data'];
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

         return view(
            'create_property_room', compact(
                'statuses','property','confRoomType','amenity'
            )
            );

        //    return view('create_room');
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
      
        $amenities='';

 

        foreach($request->amenities as $amenity)
        {

            $amenities .= $amenity.",";
        }

     

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
            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/room',
            [
            [
                'name' => 'property_id',
                'contents' => $request->property_id
            ],
            [
                'name' => 'room_type_id',
                'contents' => $request->room_type_id
            ],
            [
                'name' => 'no_of_rooms',
                'contents' => $request->no_of_rooms
            ],
            [
                'name' => 'available_rooms',
                'contents' => $request->available_rooms
            ],
            [
                'name' => 'max_adults',
                'contents' => $request->max_adults
            ],

            [
                'name' => 'max_children',
                'contents' => $request->max_children
            ],
            [
                'name' => 'max_occupancy',
                'contents' => $request->max_occupancy
            ],
            [
                'name' => 'room_location',
                'contents' => $request->room_location
            ],
            [
                'name' => 'amount',
                'contents' => $request->amount
            ],
            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ],
            [
                'name' => 'amenities[]',
                'contents' =>$amenities
            ],
      

            ]);


        }
        else{
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/room',

        [

            "property_id"=>$request->property_id,
            "room_type_id"=>$request->room_type_id,

            "no_of_rooms"=>$request->no_of_rooms,
         "available_rooms"=>$request->available_rooms,

         "max_adults"=>$request->max_adults,
         "max_children"=>$request->max_children,

         "max_occupancy"=>$request->max_occupancy,
         "room_location"=>$request->room_location,

         "amount"=>$request->amount,
         "amenities[]"=>$amenities,

            "status_id"=>$request->status_id,
           
        ]);

        }
        if($response->status()===201){

            return redirect()->route('rooms.create')->with('success','Rooms Created Successfully!');
        }else{

            $request->flash();

            return redirect()->route('rooms.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/room/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $proproom = $response['data'];



            return view(
                'view_property_room', compact(
                    'proproom'
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

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/property');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $property = $response['data'];
         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];
         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confAmenity');

            $response = json_decode($call->getBody()->getContents(), true);
           
        }catch (\Exception $e){
            


        }
         $amenity = $response['data'];
         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confRoomType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $confRoomType = $response['data'];
       
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/room/' . $id);

       
     
        

        if($response->ok()){

            $rooms =   $response->json()['data'];

        //   return $rooms;

            return view('edit_property_room', compact(
               'rooms','statuses','property','confRoomType','amenity'
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
      
        $amenities='';

     

        foreach($request->amenities as $amenity)
        {

            $amenities .= $amenity.",";
        }

      
        $amenities = rtrim($amenities,",");
        //  return  $amenities;

        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'/api/room/'.$id, 
        [
            "_method"=> 'PUT',
            "property_id"=>$request->property_id,
            "room_type_id"=>$request->room_type_id,

            "no_of_rooms"=>$request->no_of_rooms,
         "available_rooms"=>$request->available_rooms,

         "max_adults"=>$request->max_adults,
         "max_children"=>$request->max_children,

         "max_occupancy"=>$request->max_occupancy,
         "room_location"=>$request->room_location,

         "amount"=>$request->amount,
        //  "amenities[]"=>$amenities,

            "status_id"=>$request->status_id,
            "amenities"=>$amenities
        ]
        
      );

        // return $response;
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Rooms Updated Successfully!');
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/room/'.$id);

        if($response->status()==204){
            // roomtype.index
             return redirect()->route('rooms.index')->with('success','Rooms Deleted Sucessfully !..');
        }
        else{


             return redirect()->route('rooms.index')->with('error',$response->json()['message']);
        }

    }
}
