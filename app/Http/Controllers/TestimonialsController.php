<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session = session()->get('token');
        $response = Http::get(config('global.url') . '/getAllReview');
        $testimonials = $response->json()['data'];
        if ($session != null) {
            return view('alltestimonials', ['testimonials' => $testimonials, 'token' => $session]);
        } else {
            return redirect()->route('home');
        }

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createtestimonial');
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
        $file = '';
        $file_name = '';
        if ($request->file('testimonial_image') !== null) {
            $file = fopen($request->file('testimonial_image'), 'r');
            $file_name = $request->file('testimonial_image')->getClientOriginalName();
            $response = Http::attach('testimonial_image', $file, $file_name)->withToken($session)->post(config('global.url') . '/admin/testimonial/writeReview', [
                [
                    'name' => 'testimonial_name',
                    'contents' => $request->testimonial_name
                ],
                [
                    'name' => 'testimonial_title',
                    'contents' => $request->testimonial_name
                ],
                [
                    'name' => 'testimonial_date',
                    'contents' => $request->testimonial_date
                ],

                [
                    'name' => 'testimonial_desc',
                    'contents' => $request->testimonial_desc
                ]
            ]);
        }
        if ($response->headers()['Content-Type'][0] == "text/html; charset=UTF-8") {
            return redirect()->route('home');
        }
        if ($response->status() === 201) {
            return redirect()->route('testimonials.create')->with('success', 'testimonial Created Successfully!');
        } else {
            return redirect()->route('testimonials.create')->with('error', $response->json());
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
        $response = Http::withToken($session)->get(config('global.url') . '/review/' . $id);
        if ($response->ok()) {
            $testimonial =   $response->json()['data'];
            return view('showtestimonial', ['testimonial' => $testimonial]);
        }
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
        $response = Http::withToken($session)->get(config('global.url') . '/review/' . $id);
        if ($response->ok()) {
            $testimonial =   $response->json()['data'];
            return view('edittestimonial', ['testimonial' => $testimonial]);
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
        if ($request->file('testimonial_image') !== null) {
            $file = fopen($request->file('testimonial_image'), 'r');
            $file_name = $request->file('testimonial_image')->getClientOriginalName();
            $response = Http::attach('testimonial_image', $file, $file_name)->withToken($session)->post(config('global.url') . '/admin/testimonial/editReview/' . $id, [
                [
                    'name' => '_method',
                    'contents' => 'PUT'
                ],
                [
                    'name' => 'testimonial_name',
                    'contents' => $request->testimonial_name
                ],
                [
                    'name' => 'testimonial_title',
                    'contents' => $request->testimonial_name
                ],
                [
                    'name' => 'testimonial_date',
                    'contents' => $request->testimonial_date
                ],

                [
                    'name' => 'testimonial_desc',
                    'contents' => $request->testimonial_desc
                ]
            ]);
        }else{
            return redirect()->route('testimonials.edit', ['testimonial' => $id])->with('error',array(array('Server Error')) );
        }
        if ($response->headers()['Content-Type'][0] == "text/html; charset=UTF-8") {
            return redirect()->route('home');
        }

        if ($response->status() === 201) {
            return redirect()->route('testimonials.edit', ['testimonial' => $id])->with('success', 'Testimonial Updated Successfully');
        } else {
            return redirect()->route('testimonials.edit', ['testimonial' => $id])->with('error', $response->json());
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
        $response = Http::withToken($session)->delete(config('global.url') . '/admin/testimonial/deleteReview/' . $id);
        if ($response->serverError()) {
            $error = [['Server Error']];
            return redirect()->route('testimonials.index')->with('error', $error);
        }
        if ($response->headers()['Content-Type'][0] == "text/html; charset=UTF-8") {

            return redirect()->route('home');
        }
        if ($response->ok()) {
            return redirect()->route('testimonials.index')->with('success', 'Testimonial Deleted Sucessfully !..');
        } else {
            return redirect()->route('testimonials.index')->with('error', $response->json()['message']);
        }
    }
}
