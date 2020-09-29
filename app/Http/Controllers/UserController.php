<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$page = 1)
    {
        $token = session()->get('token');

        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/users?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }

        $users = $response['data'];

        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

        return view('user_list', compact('users', 'pagination','lastpage'));

    }
    public function login(Request $request)
    {
        // echo config('global.url');exit;
        $respose = Http::withHeaders([
            'Accept' => 'application/vnd.api.v1+json',
            'Content-Type' => 'application/json'
        ])->post(config('global.url').'/oauth/token', [
            "grant_type" => "password",
            "client_id" => 2,
            "client_secret" => "Hridhamtech",
            "username" => $request->username,
            "password" => $request->password,
            "scope" => ''
        ]);

        if($respose->ok()){

            $request->session()->put('token',$respose->json()['access_token']);

            $request->session()->save();

            $token = session()->get('token');

            try{

                $profresponse = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') .'api/me');

                // $profresponse = json_decode($call->getBody()->getContents(), true);

               
               
            }catch (\Exception $e){
                //buy a beer


            }

            if($profresponse->ok()){

                // return $profresponse->json()['data']['name'];
                
                $username = $profresponse->json()['data']['name'];

                $request->session()->put('username',$username);
        
                $request->session()->save();

            }

            return redirect()->route('booking.index');
       
        }
        else{

            return redirect()->route('home')->with($respose->json());
        }
        //  return 1;
        //
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/roles');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $roles = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/permissions?limit=1000');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $permissions = $response['data'];

         return view(
                'create_user', compact(
                    'roles','permissions'
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


        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/users',

        [

            "name"=>$request->name,

            "email"=>$request->email,

            "password"=>$request->password,

            "password_confirmation"=>$request->password_confirmation,

            "roles"=>$request->roles

        ]);
        // dd($request->all());

        // dd($response);
        // echo $response->status();exit;

        if($response->status()===201){

            return redirect()->route('users.create')->with('success','User Created Successfully!');
        }else{
            // var_dump($response);exit;
          // return dd($response->json());
            $request->flash();
            return redirect()->route('users.create')->with('error',$response['errors']);
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
        $session = session()->get('token');


        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/roles');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $roles = $response['data'];



       
         $response=Http::withToken($session)->get(config('global.url').'/api/users/'.$id);


        if($response->ok()){

            $user= $response->json()['data'];

            return view('edit_user', compact(
                'roles','user'
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
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/users/'.$id, 
        
        [
            "_method"=> 'PUT',
            "name"=>$request->name,
            "email"=>$request->email,
            "roles"=>$request->roles,
           
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','User Updated Successfully!');
        }else{
            return redirect()->back()->with('error',$response['errors']);
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/users/'.$id);
    
        if($response->status()==204){

             return redirect()->route('user.index')->with('success','User Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('user.index')->with('error',$response->json()['message']);
        }
    }

    public function logout()
    {

        session()->flush();

        session()->forget('token');

        return redirect()->route('home')->with('success','You have logged out Sucessfully !..');

    }
}
