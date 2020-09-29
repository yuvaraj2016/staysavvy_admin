<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupplierController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $suppliers = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

          return view('supplier_list', compact('suppliers', 'pagination','lastpage'));
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confSupplierCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $suppliercategories = $scresponse['data'];



       try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];


            return view(
                'create_supplier', compact(
                    'suppliercategories','statuses',
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

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/suppliers',
            [
            [
                'name' => 'supplier_name',
                'contents' => $request->supplier_name
            ],
            [
                'name' => 'supplier_category_id',
                'contents' => $request->supplier_category_id
            ],
            [
                'name' => 'supplier_desc',
                'contents' => $request->supplier_desc
            ],
            [
                'name' => 'supplier_address',
                'contents' => $request->supplier_address
            ],
            [
                'name' => 'supplier_contact',
                'contents' => $request->supplier_contact
            ],
            [
                'name' => 'supplier_email',
                'contents' => $request->supplier_email
            ],
            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ],

            ]);


        }



        else{
            $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/suppliers', [
                "supplier_name"=>$request->supplier_name,
                "supplier_category_id"=>$request->supplier_category_id,
                "supplier_desc"=>$request->supplier_desc,
                "supplier_address"=>$request->supplier_address,
                "supplier_contact"=>$request->supplier_contact,
                "supplier_email"=>$request->supplier_email,
                "status_id"=>$request->status_id,

            ]);
            // dd($response);
        }

        if($response->status()==201){
            // return redirect()->route('suppliers.create')->with('success','Supplier Created Successfully!');
            return redirect()->back()->with('success','Supplier Created Successfully!');
        }else{
            $request->flash();

            return redirect()->route('suppliers.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);

        }catch (\Exception $e){



        }
         $supplier = $response['data'];



            return view(
                'view_supplier', compact(
                    'supplier'
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
        //

        $session = session()->get('token');


        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confSupplierCat');

            $supcatresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $suppliercat = $supcatresponse['data'];



        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $stsresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $stsresponse['data'];

         $supresponse=Http::withToken($session)->get(config('global.url').'/api/suppliers/'.$id);


        if($supresponse->ok()){

            $supplier= $supresponse->json()['data'];

            return view('edit_supplier', compact(
                'suppliercat','supplier','statuses'
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



        $session = session()->get('token');
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/suppliers/'.$id, 
        
        [
            "_method"=> 'PUT',
            "supplier_name"=>$request->supplier_name,
                "supplier_category_id"=>$request->supplier_category_id,
                "supplier_desc"=>$request->supplier_desc,
                "supplier_address"=>$request->supplier_address,
                "supplier_contact"=>$request->supplier_contact,
                "supplier_email"=>$request->supplier_email,
                "status_id"=>$request->status_id,
            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Suppliers Updated Successfully!');
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/suppliers/'.$id);

        if($response->status()==204){

             return redirect()->route('supplier.index')->with('success','Supplier Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('supplier.index')->with('error',$response->json()['message']);
        }

    }
}
