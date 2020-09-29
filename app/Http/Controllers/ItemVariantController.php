<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemVariantController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariant?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $item_variants = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

          return view('item_variant_list', compact('item_variants', 'pagination','lastpage'));
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/item');

            $iresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $items = $iresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariantGroup');

            $iresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $itemvariantgroup = $iresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $vresponse = json_decode($call->getBody()->getContents(), true);
            //   return $vresponse;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendors = $vresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorstores = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $subcategories = $scresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $suppliers = $scresponse['data'];

       try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];


            return view(
                'create_item_variant', compact(
                    'items','statuses','itemvariantgroup','vendors','subcategories','suppliers','vendorstores'
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

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/itemVariant',
            [
            [
                'name' => 'item_id',
                'contents' => $request->item_id
            ],
            [
                'name' => 'variant_code',
                'contents' => $request->variant_code
            ],
            [
                'name' => 'variant_desc',
                'contents' => $request->variant_desc
            ],
            [
                'name' => 'MRP',
                'contents' => $request->MRP
            ],
            [
                'name' => 'selling_price',
                'contents' => $request->selling_price
            ],
            [
                'name' => 'variant_group_id',
                'contents' => $request->variant_group_id
            ],

            [
                'name' => 'default',
                'contents' => $request->default
            ],
            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ],

            [
                'name' => 'min_order_quantity',
                'contents' => $request->min_order_quantity
            ],
            [
                'name' => 'min_order_amount',
                'contents' => $request->min_order_amount
            ],
            [
                'name' => 'max_order_quantity',
                'contents' => $request->max_order_quantity
            ],
            [
                'name' => 'max_order_amount',
                'contents' => $request->max_order_amount
            ],
            [
                'name' => 'quantity',
                'contents' => $request->quantity
            ],
            [
                'name' => 'threshold',
                'contents' => $request->threshold
            ],
            [
                'name' => 'discount_percentage',
                'contents' => $request->discount_percentage
            ],
            [
                'name' => 'discount_amount',
                'contents' => $request->discount_amount
            ],
            [
                'name' => 'supplier_id',
                'contents' => $request->supplier_id
            ],
            [
                'name' => 'vendor_store_id',
                'contents' => $request->vendor_store_id
            ],
            [
                'name' => 'title',
                'contents' => $request->title
            ],
            [
                'name' => 'vendor_id',
                'contents' => $request->vendor_id
            ]

            ]);


        }



        else{
            $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/itemVariant', [
                "item_id"=>$request->item_id,
                "variant_code"=>$request->variant_code,
                "variant_desc"=>$request->variant_desc,

                "MRP"=>$request->MRP,
                "selling_price"=>$request->selling_price,
                "variant_group_id"=>$request->variant_group_id,
                "default"=>$request->default,
                "status_id"=>$request->status_id,


                "min_order_quantity"=>$request->min_order_quantity,
                "min_order_amount"=>$request->min_order_amount,
                "max_order_quantity"=>$request->max_order_quantity,
                "max_order_amount"=>$request->max_order_amount,
                "quantity"=>$request->quantity,


                "threshold"=>$request->threshold,
                "discount_percentage"=>$request->discount_percentage,
                "discount_amount"=>$request->discount_amount,
                "supplier_id"=>$request->supplier_id,
                "vendor_store_id"=>$request->vendor_store_id,
                "title"=>$request->title,
                "vendor_id"=>$request->vendor_id,











            ]);
           //  dd($response);
        }

        if($response->status()==201){
            return redirect()->route('item_variants.create')->with('success','Item Variant Created Successfully!');
        }else{
            $request->flash();

            return redirect()->route('item_variants.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariant/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);

        }catch (\Exception $e){



        }
         $itemvariant = $response['data'];



            return view(
                'view_item_variant', compact(
                    'itemvariant'
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

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/item');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $item = $response['data'];


         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariantGroup');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $itemvariantgroup = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $suppliers = $response['data'];


         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendors = $response['data'];


         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorstores = $response['data'];


        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         $response=Http::withToken($session)->get(config('global.url').'/api/itemVariant/'.$id);
        // return $response;

        if($response->ok()){

            $itemVariants= $response->json()['data'];
           //  return $itemVariants['id'];
            return view('edit_item_variant', compact(
                'item','statuses','itemVariants','itemvariantgroup','suppliers','vendors','vendorstores'
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
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/itemVariant/'.$id, 
        
        [
            "_method"=> 'PUT',
            "item_id"=>$request->item_id,
            "variant_code"=>$request->variant_code,
            "variant_desc"=>$request->variant_desc,

            "MRP"=>$request->MRP,
            "selling_price"=>$request->selling_price,
            "variant_group_id"=>$request->variant_group_id,
            "default"=>$request->default,
            "status_id"=>$request->status_id,


            "min_order_quantity"=>$request->min_order_quantity,
            "min_order_amount"=>$request->min_order_amount,
            "max_order_quantity"=>$request->max_order_quantity,
            "max_order_amount"=>$request->max_order_amount,
            "quantity"=>$request->quantity,


            "threshold"=>$request->threshold,
            "discount_percentage"=>$request->discount_percentage,
            "discount_amount"=>$request->discount_amount,
            "supplier_id"=>$request->supplier_id,
            "vendor_store_id"=>$request->vendor_store_id,
            "title"=>$request->title,
            
            "vendor_id"=>$request->vendor_id


            
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Item Variants Updated Successfully!');
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/itemVariant/'.$id);
       // return $response->status();
        // if($response->serverError()){
        //     $error=[['Server Error'],['Please Delete All Photos to this Album']];
        //     return redirect()->route('albums.index')->with('error',$error);
        // }
        // if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
        //     return redirect()->route('home');
        // }
        if($response->status()==204){

             return redirect()->route('item_variant.index')->with('success','Item Variant Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('item_variant.index')->with('error',$response->json()['message']);
        }
    }


    public function getallitemvariants()
    {
        $token = session()->get('token');
        
        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariant');

            $ivresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorstores = $ivresponse['data'];

         return $vendorstores;

    }
}
