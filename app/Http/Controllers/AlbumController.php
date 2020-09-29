<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
class AlbumController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $session = session()->get('token');
        $response = Http::get(config('global.url').'/getAllAlbums');
        $albums = $response->json()['message'];
        return view('allalbum', ['albums' => $albums, 'token' => $session]);
        // return session()->all();
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // return dd(session()->get('token'));
        return view('createalbum');
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
        $file = '';
        $file_name = '';
        if ($request->file('cover_picture') !== null) {
            $file = fopen($request->file('cover_picture'), 'r');
            $file_name = $request->file('cover_picture')->getClientOriginalName();
            $response = Http::attach('cover_picture', $file, $file_name)->withToken($session)->post(config('global.url').'/admin/gallery/createAlbum', [
                [
                    'name' => 'album_name',
                    'contents' => $request->album_name
                ],
                [
                    'name' => 'privacy',
                    'contents' => $request->privacy
                ],
                [
                    'name' => 'album_date',
                    'contents' => $request->album_date
                ],
                [
                    'name' => 'album_venue',
                    'contents' => $request->album_venue
                ],
                [
                    'name' => 'album_description',
                    'contents' => $request->album_description
                ]
            ]);

        }else{
            $response = Http::withToken($session)->post(config('global.url').'/admin/gallery/createAlbum', [
                "album_name"=>$request->album_name,
                "privacy"=>$request->privacy,
                "album_date"=>$request->album_date,
                "album_venue"=>$request->album_venue,
                "album_description"=>$request->album_description
            ]);
        }
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===201){
            return redirect()->route('albums.create')->with('success','Album Created Successfully!');
        }else{
            return redirect()->route('albums.create')->with('error',$response->json());
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
        $session = session()->get('token');
        $response=Http::withToken($session)->get(config('global.url').'/albums/'.$id);
        if($response->ok()){
            $albums=   $response->json()['data'];
            $photos=$response->json()['photos'];
            return view('showalbum',['albums'=>$albums,'photos'=>$photos]);
        }
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
        $response=Http::withToken($session)->get(config('global.url').'/albums/'.$id);
        if($response->ok()){
            $albums=   $response->json()['data'];
            return view('editalbum',['albums'=>$albums]);
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
        $file = '';
        $file_name = '';
        if ($request->file('cover_picture') !== null) {
            $file = fopen($request->file('cover_picture'), 'r');
            $file_name = $request->file('cover_picture')->getClientOriginalName();
            $response = Http::attach('cover_picture', $file, $file_name)->withToken($session)->post(config('global.url').'/admin/gallery/updateAlbum/'.$id, [
                [
                    'name' => '_method',
                    'contents' => 'PUT'
                ],
                [
                    'name' => 'album_name',
                    'contents' => $request->album_name
                ],
                [
                    'name' => 'privacy',
                    'contents' => $request->privacy
                ],
                [
                    'name' => 'album_date',
                    'contents' => $request->album_date
                ],
                [
                    'name' => 'album_venue',
                    'contents' => $request->album_venue
                ],
                [
                    'name' => 'album_description',
                    'contents' => 'Test'
                ]
            ]);

        }else{
            $response = Http::withToken($session)->put(config('global.url').'/admin/gallery/updateAlbum/'.$id, [
                "album_name"=>$request->album_name,
                "privacy"=>$request->privacy,
                "album_date"=>$request->album_date,
                "album_venue"=>$request->album_venue,
                "album_description"=>$request->album_description
            ]);
        }
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->to('albums/'.$id.'/edit')->with('success','Album Updated Successfully!');
        }else{
            return redirect()->to('albums/'.$id.'/edit')->with('error',$response->json());
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
        $response=Http::withToken($session)->delete(config('global.url').'/admin/gallery/deleteAlbum/'.$id);
        if($response->serverError()){
            $error=[['Server Error'],['Please Delete All Photos to this Album']];
            return redirect()->route('albums.index')->with('error',$error);
        }
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->ok()){
            // $albums=   $response->json()['message'];
            // $photos=$response->json()['photos'];
            // return response()->json([
            //     'success' => 'Record deleted successfully!'
            // ]);
             return redirect()->route('albums.index')->with('success','Album Deleted Sucessfully !..');
        }
        else{
            // return response()->json([
            //     'success' => 'Record deleted successfully!'
            // ]);

             return redirect()->route('albums.index')->with('error',$response->json()['message']);
        }
        //
    }
}
