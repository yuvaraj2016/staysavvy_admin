<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PhotoController extends Controller
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
    public function create($album_id)
    {
        //
        return view('createphoto', ['album_id' => $album_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $album_id)
    {
        $session = session()->get('token');
        $file = '';
        $file_name = '';
        if ($request->file('photo') !== null) {

            $file = fopen($request->file('photo'), 'r');
            $file_name = $request->file('photo')->getClientOriginalName();
            $response = Http::attach('photo', $file, $file_name)->withToken($session)->post(config('global.url') . '/admin/gallery/createPhotos', [
                [
                    'name' => 'album_id',
                    'contents' => $album_id
                ],
                [
                    'name' => 'privacy',
                    'contents' => $request->privacy
                ],
                [
                    'name' => 'type',
                    'contents' => 1
                ],
                [
                    'name' => 'photo_description',
                    'contents' => $request->photo_description
                ]

            ]);
        } else {
            $response = Http::withToken($session)->post(config('global.url') . '/admin/gallery/createPhotos', [
                "album_id" => $album_id,
                "type" => 1,
                "privacy" => $request->privacy,
                "photo_description" => $request->photo_description
            ]);
        }

        if ($response->headers()['Content-Type'][0] == "text/html; charset=UTF-8") {
            return redirect()->route('home');
        }
        if ($response->status() === 201) {
            return redirect()->route('albums.photo.create', ['album' => $album_id])->with('success', 'Photo Created Successfully!');
        } else {
            return redirect()->route('albums.photo.create', ['album' => $album_id])->with('error', $response->json());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($album_id, $photo_id)
    {
        $session = session()->get('token');
        $response=Http::withToken($session)->get(config('global.url').'/photos/'.$photo_id);
        if($response->ok()){
            $photos=   $response->json()['data'];
            return view('showphoto',['photos'=>$photos,'album_id'=>$album_id]);
        }
        // return ($album_id . '-' . $photo_id);
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($album_id, $photo_id)
    {
        $session = session()->get('token');
        $response = Http::withToken($session)->get(config('global.url') . '/photos/' . $photo_id);
        if ($response->ok()) {
            $photos =   $response->json()['data'];
            return view('editphoto', ['photos' => $photos, 'album_id' => $album_id, 'photo_id' => $photo_id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $album_id, $photo_id)
    {

        $session = session()->get('token');
        $file = '';
        $file_name = '';

        if ($request->file('photo') !== null) {

            $file = fopen($request->file('photo'), 'r');
            $file_name = $request->file('photo')->getClientOriginalName();
            $response = Http::attach('photo', $file, $file_name)->withToken($session)->post(config('global.url') . '/admin/gallery/updatePhotos/' . $photo_id, [
                [
                    'name' => 'album_id',
                    'contents' => $album_id
                ],
                [
                    'name' => 'privacy',
                    'contents' => $request->privacy
                ],
                [
                    'name' => '_method',
                    'contents' => 'PUT'
                ],
                [
                    'name' => 'type',
                    'contents' => 1
                ],
                [
                    'name' => 'photo_description',
                    'contents' => $request->photo_description
                ]

            ]);
        } else {
            $response = Http::withToken($session)->put(config('global.url') . '/admin/gallery/updatePhotos/' . $photo_id, [
                "album_id" => $album_id,
                "type" => 1,
                "privacy" => $request->privacy,
                "photo_description" => $request->photo_description
            ]);
        }

        if ($response->headers()['Content-Type'][0] == "text/html; charset=UTF-8") {
            return redirect()->route('home');
        }
        if ($response->status() === 200) {
            return redirect()->route('albums.photo.edit', ['album' => $album_id, 'photo' => $photo_id])->with('success', 'Photo Updated Successfully!');
        } else {
            return redirect()->route('albums.photo.edit', ['album' => $album_id, 'photo' => $photo_id])->with('error', $response->json());
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($album_id, $photo_id)
    {
        $session = session()->get('token');
        $response=Http::withToken($session)->delete(config('global.url').'/admin/gallery/deletePhotos/'.$photo_id);
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->ok()){
            // $albums=   $response->json()['message'];
            // $photos=$response->json()['photos'];
            // return response()->json([
            //     'success' => 'Record deleted successfully!'
            // ]);
             return redirect()->route('albums.show',['album'=>$album_id])->with('success','Photo Deleted Sucessfully !..');
        }
        else{
            // return response()->json([
            //     'success' => 'Record deleted successfully!'
            // ]);
             return redirect()->route('albums.show',['album'=>$album_id])->with('error',$response->json()['message']);
        }
    }
}
