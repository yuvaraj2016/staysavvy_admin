<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoleController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/roles?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }

        $roles = $response['data'];

        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

        return view('role_list', compact('roles', 'pagination','lastpage'));
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/permissions?limit=1000');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $permissions = $response['data'];

       
         return view(
                'create_role', compact(
                    'permissions'
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


        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/roles',

        [

            "name"=>$request->name,

             "permissions"=>$request->permissions

        ]);
        // dd($request->all());

        // dd($response);
        // echo $response->status();exit;

        // return $response;

        if($response->status()===201){

            // return redirect()->route('roles.create')->with('success','Role Created Successfully!');
            return redirect()->back()->with('success','Role Created Successfully!');
        }else{
            // var_dump($response);exit;
          // return dd($response->json());
            $request->flash();
            return redirect()->route('roles.create')->with('error',$response->json()['message']);
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

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/permissions?limit=1000');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $permissions = $response['data'];



       
         $response=Http::withToken($session)->get(config('global.url').'/api/roles/'.$id);


        if($response->ok()){

            $role= $response->json()['data'];

            return view('edit_role', compact(
                'permissions','role'
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
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/roles/'.$id, 
        
        [
            "_method"=> 'PUT',
            "name"=>$request->name,
            "permissions"=>$request->permissions
           
           
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Role Updated Successfully!');
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

        // return $id;
        $session = session()->get('token');

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/roles/'.$id);
    
        if($response->status()==204){

             return redirect()->route('role.index')->with('success','Role Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('role.index')->with('error',$response['message']);
        }
    }
}
