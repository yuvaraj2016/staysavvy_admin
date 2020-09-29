<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;

class ProductSubCategoryController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $prodsubcategories = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

          return view('product_sub_category_list', compact('prodsubcategories', 'pagination','lastpage'));
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


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $categories = $scresponse['data'];


            return view(
                'create_product_sub_category', compact(
                    'statuses','categories'
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

    //    dd($request->all());
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

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/prodSubCat',
            [
            [
                'name' => 'category_id',
                'contents' => $request->category_id
            ],
            [
                'name' => 'sub_category_short_code',
                'contents' => $request->sub_category_short_code
            ],
            [
                'name' => 'sub_category_desc',
                'contents' => $request->sub_category_desc
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
            $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/prodSubCat', [
                "category_id"=>$request->category_id,
                "sub_category_short_code"=>$request->sub_category_short_code,
                "sub_category_desc"=>$request->sub_category_desc,

                "title"=>$request->title,
                // "file"=>$request->file,
                "status_id"=>$request->status_id

            ]);
            // dd($response);
        }

        if($response->status()==201){
            // return redirect()->route('product_sub_categories.create')->with('success','Product Sub Category Created Successfully!');
            return redirect()->back()->with('success','Product Sub Category Created Successfully!');
        }else{
            $request->flash();

            return redirect()->route('product_sub_categories.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $productsubcategory = $response['data'];



            return view(
                'view_product_sub_category', compact(
                    'productsubcategory'
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

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodCat');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $prodcategories = $response['data'];



        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         $response=Http::withToken($session)->get(config('global.url').'/api/prodSubCat/'.$id);


        if($response->ok()){

            $prodsubcategory= $response->json()['data'];

            return view('edit_product_sub_category', compact(
                'prodcategories','prodsubcategory','statuses'
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
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/prodSubCat/'.$id, 
        
        [
            "_method"=> 'PUT',
            "category_id"=>$request->category_id,
            "sub_category_short_code"=>$request->sub_category_short_code,
            "sub_category_desc"=>$request->sub_category_desc,
            "title"=>$request->title,
            "status_id"=>$request->status_id
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Product Sub Category Updated Successfully!');
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/prodSubCat/'.$id);

        if($response->status()==204){

             return redirect()->route('product_sub_cat.index')->with('success','Product Sub Category Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('product_sub_cat.index')->with('error',$response->json()['message']);
        }
    }


    public function getallsubcategories()
    {
        $token = session()->get('token');
        
        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $subcategories = $scresponse['data'];

         return $subcategories;

    }
    
}
