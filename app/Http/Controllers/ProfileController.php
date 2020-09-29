<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProfileController extends Controller
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

    public function index(Request $request)
    {
        //

        $token = session()->get('token');
        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/me');

            $response = json_decode($call->getBody()->getContents(), true);
        
        }catch (\Exception $e){
            //buy a beer


        }
        $profile = $response['data'];
       // return $profile;
        // $pagination = $response['meta']['pagination'];

        // $lastpage = $pagination['total_pages'];

          return view('show_profile', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $token = session()->get('token');
    //     try{

    //         $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

    //         $response = json_decode($call->getBody()->getContents(), true);
    //         //  return $response;
    //     }catch (\Exception $e){
    //         //buy a beer


    //     }
    //      $statuses = $response['data'];



    //         return view(
    //             'create_vendor_category', compact(
    //                 'statuses'
    //             )
    //     );
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $session = session()->get('token');


    //     $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/me',

    //     [

    //         "name"=>$request->name,

    //         "email"=>$request->email

    //     ]);
      

    //     if($response->status()===201){

    //         return redirect()->route('vendor_categories.create')->with('success','Vendor Category Created Successfully!');
    //     }
    //     else{

    //         $request->flash();

    //         return redirect()->route('vendor_categories.create')->with('error',$response['errors']);
    //     }
    // }

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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/me/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);
              return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $profile = $response['data'];

        //return $profile;

            return view(
                'view_profiles', compact(
                    'profile'
                )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $session = session()->get('token');

        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') .'/api/me/');
       // return $response;

        if($response->ok()){

            $profile=   $response->json()['data'];
           // return $profile;
            return view('edit_profile', compact(
                'profile'
            ));
        }
    }


    public function passwordedit()
    {
        $session = session()->get('token');

      

       

           
           // return $password;
            return view('change_password');
     
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

    //    return $request->all();
        $session = session()->get('token');
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'/api/me', 
        [
            "_method"=> 'PUT',
            "name"=>$request->name,
            "email"=>$request->email
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Profile Updated Successfully!');
        }else{
            return redirect()->back()->with('error',$response->json()['message']);
        }

    }


    public function updatepassword(Request $request)
    {

    //    return $request->all();
        $session = session()->get('token');
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'/api/me/password', 
        [
            "_method"=> 'PUT',
            "current_password"=>$request->current_password,
            "password"=>$request->password,
            "password_confirmation"=>$request->password_confirmation
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','password Updated Successfully!');
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
        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/me/'.$id);
       // return $response->status();
        // if($response->serverError()){
        //     $error=[['Server Error'],['Please Delete All Photos to this Album']];
        //     return redirect()->route('albums.index')->with('error',$error);
        // }
        // if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
        //     return redirect()->route('home');
        // }
        if($response->status()==204){

             return redirect()->route('profile.index')->with('success','Profile Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('profile.index')->with('error',$response->json()['message']);
        }

    }
}
