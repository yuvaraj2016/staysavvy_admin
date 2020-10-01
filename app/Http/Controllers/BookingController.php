<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
class BookingController extends Controller
{
    

    public function __construct(Http $client)
    {
       
               
        $this->client = $client;

       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$page = 1)
    {

        //  echo $page;
        // $response='';


        $token = session()->get('token');

        //   if(session()->has('token'))
        // {
            
        // }
        // else {

        //     return redirect()->route('home');
        // }
        
     
             return view('booking_list');
    

       
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];



            return view(
                'create_product_category', compact(
                    'statuses'
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

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/prodCat',
            [
            [
                'name' => 'category_short_code',
                'contents' => $request->category_short_code
            ],
            [
                'name' => 'category_desc',
                'contents' => $request->category_desc
            ],

            [
                'name' => 'title',
                'contents' => $request->title
            ],

            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ]
            ]);


        }



        else{
            $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/prodCat', [
                "category_short_code"=>$request->category_short_code,
                "category_desc"=>$request->category_desc,
                "title"=>$request->title,
                
                // "file"=>$request->file,
                "status_id"=>$request->status_id

            ]);

        }
        // return $response;

        if($response->status()===201){
            // return redirect()->route('product_categories.create')->with('success','Product Category Created Successfully!');
            return redirect()->back()->with('success','Product Category Created Successfully!');
        }else{
            $request->flash();
            return redirect()->route('product_categories.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodCat/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $productcategory = $response['data'];



            return view(
                'view_product_category', compact(
                    'productcategory'
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

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         $response=Http::withToken($session)->get(config('global.url').'/api/prodCat/'.$id);


        if($response->ok()){

            $prodcategory=   $response->json()['data'];

            return view('edit_product_category', compact(
                'prodcategory','statuses'
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
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/prodCat/'.$id, 
        
        [
            "_method"=> 'PUT',
            "category_short_code"=>$request->category_short_code,
            "category_desc"=>$request->category_desc,
            "title"=>$request->title,
            "status_id"=>$request->status_id
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Product Category Updated Successfully!');
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
        // return config('global.url');
        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/prodCat/'.$id);
       // return $response->status();
        // if($response->serverError()){
        //     $error=[['Server Error'],['Please Delete All Photos to this Album']];
        //     return redirect()->route('albums.index')->with('error',$error);
        // }
        // if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
        //     return redirect()->route('home');
        // }
        if($response->status()==204){

             return redirect()->route('product_cat.index')->with('success','Product Category Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('product_cat.index')->with('error',$response->json()['message']);
        }
    }


    public function getsubcategories($id)
    {
    //   return $id;
        $session = session()->get('token');


        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url').'api/member/prodCat/'.$id.'?include=SubCategories');

        

        if($response->ok()){

            $prodcategory= $response->json()['data'];;

            return $prodcategory;
        }

    }
}
