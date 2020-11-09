<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $session = session()->get('token');

        $module =  $request->segment(3);

        $id =  $request->segment(4);

        if($module=="properties")
        {
            $apicall = "api/property/".$id;
            // $view = "edit_image_product_category";
        }
elseif($module=="rooms")
{
    $apicall = "api/room/".$id;
    // $view = "edit_image_room";
}
    
       
       
        // echo $session;exit;
        // dd($session);
        $fileext = '';
        $filename = '';
        if ($request->file('file') !== null) {

            $files =$request->file('file');
            // var_dump($files);exit;
            $response = Http::withToken($session);
            foreach($files as $k => $ufile)
            {
                $filename = fopen($ufile, 'r');
                $fileext = $ufile->getClientOriginalName();
                $response = $response->attach('file['.$k.']', $filename,$fileext);
            }

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . $apicall,
         
            [ [   
             
                'name' => '_method',
                'contents' => 'PATCH'
              ]     
            ]);

            // $response = json_decode($response->getBody()->getContents(), true);

           //  return $response;

            if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
                return redirect()->route('home');
            }
            if($response->status()===200){
                return redirect()->back()->with('uploadsuccess','Image Uploaded Successfully!');
            }else{
                return redirect()->back()->with('uploaderror',$response->json());
            }
     
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

    public function editimage(Request $request)
    {
        $module =  $request->segment(1);
        $id =  $request->segment(2);
        // return $id;
        if($module=="properties")
        {
            $apicall = "api/property/".$id;
            $view = "edit_image_properties";
        }

       elseif($module=="rooms")
       {
           $apicall = "api/room/".$id;
           $view = "edit_image_room";
       }
// return $apicall;
       
        
        $session = session()->get('token');


       
        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url').$apicall);

       //  return $response;

        if($response->ok()){

            $editdata=   $response->json()['data'];

            return view($view, compact(
                'editdata'
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/assets/'.$id);

        if($response->status()==204){

             return redirect()->back()->with('imagesuccess','Image Deleted Sucessfully !..');
        }
        else{


             return redirect()->back()->with('imageerror',$response->json()['message']);
        }

    }
}
