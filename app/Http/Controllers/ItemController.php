<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/item?page='.$page);

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $items = $response['data'];
        $pagination = $response['meta']['pagination'];

        $lastpage = $pagination['total_pages'];

          return view('item_list', compact('items', 'pagination','lastpage'));
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $subcategories = $scresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confVendorCat');

            $vcresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorcategories = $vcresponse['data'];



        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendors = $response['data'];
         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $categories = $scresponse['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers');

            $suresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $supplier = $suresponse['data'];



         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

            $suresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorstore = $suresponse['data'];




        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];


            return view(
                'create_item', compact(
                    'subcategories','vendors','statuses','vendorcategories','categories','supplier','vendorstore'
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

            $response = $response->withHeaders(['Accept'=>'application/vnd.api.v1+json'])->post(config('global.url') . '/api/item',
            [
            [
                'name' => 'item_code',
                'contents' => $request->item_code
            ],
            [
                'name' => 'item_desc',
                'contents' => $request->item_desc
            ],
            [
                'name' => 'sub_category_id',
                'contents' => $request->sub_category_id
            ],
            [
                'name' => 'status_id',
                'contents' => $request->status_id
            ],
            [
                'name' => 'vendor_id',
                'contents' => $request->vendor_id
            ],



            [
                'name' => 'category_id',
                'contents' => $request->category_id
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
                'name' => 'discount_percentage',
                'contents' => $request->discount_percentage
            ],
            [
                'name' => 'discount_amount',
                'contents' => $request->discount_amount
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
                'name' => 'supplier_id',
                'contents' => $request->supplier_id
            ],
            [
                'name' => 'MRP',
                'contents' => $request->MRP
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
                'name' => 'selling_price',
                'contents' => $request->selling_price
            ]

            ]);


        }



        else{
            $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/item', [
                "item_code"=>$request->item_code,
                "item_desc"=>$request->item_desc,
                "sub_category_id"=>$request->sub_category_id,
                "status_id"=>$request->status_id,
                "vendor_id"=>$request->vendor_id,


                "category_id"=>$request->category_id,
                "min_order_quantity"=>$request->min_order_quantity,
                "min_order_amount"=>$request->min_order_amount,
                "max_order_quantity"=>$request->max_order_quantity,
                "max_order_amount"=>$request->max_order_amount,


                "quantity"=>$request->quantity,
                "threshold"=>$request->threshold,
                "discount_percentage"=>$request->discount_percentage,
                "discount_amount"=>$request->discount_amount,
                "supplier_id"=>$request->supplier_id,

                "MRP"=>$request->MRP,
                "vendor_store_id"=>$request->vendor_store_id,
                "title"=>$request->title,
                "selling_price"=>$request->selling_price


            ]);
            // dd($response);
        }

        if($response->status()==201){
            // return redirect()->route('items.create')->with('success','Item Created Successfully!');
            return redirect()->back()->with('success','Item Created Successfully!');
        }else{
            $request->flash();

            return redirect()->route('items.create')->with('error',$response['errors']);
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/item/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);

        }catch (\Exception $e){



        }
         $item = $response['data'];



            return view(
                'view_item', compact(
                    'item'
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

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $prodSubCat = $response['data'];



        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodCat');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $prodCat = $response['data'];



         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorStore = $response['data'];


         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $suppliers = $response['data'];



        try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];

         try{

            $call = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendors = $response['data'];



         $response=Http::withToken($session)->get(config('global.url').'/api/item/'.$id);
         //return $response;

        if($response->ok()){

            $item= $response->json()['data'];
        //    return $item['id'];
            return view('edit_item', compact(
                'prodSubCat','vendors','statuses','item','prodCat','suppliers','vendorStore'
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
// return $id;
        $session = session()->get('token');
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/item/'.$id, 
        
        [
            "_method"=> 'PUT',
                    
            "item_code"=>$request->item_code,
                "item_desc"=>$request->item_desc,
                "sub_category_id"=>$request->sub_category_id,
                "status_id"=>$request->status_id,
                "vendor_store_id"=>$request->vendor_store_id,


                "vendor_id"=>$request->vendor_id,
                "category_id"=>$request->category_id,
                "min_order_quantity"=>$request->min_order_quantity,
                "min_order_amount"=>$request->min_order_amount,
                "max_order_quantity"=>$request->max_order_quantity,
                "max_order_amount"=>$request->max_order_amount,


                "quantity"=>$request->quantity,
                "threshold"=>$request->threshold,
                "discount_percentage"=>$request->discount_percentage,
                "discount_amount"=>$request->discount_amount,
                "supplier_id"=>$request->supplier_id,
                "title"=>$request->title,
                "MRP"=>$request->MRP,
                "selling_price"=>$request->selling_price

        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Item Updated Successfully!');
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

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/item/'.$id);
       // return $response->status();
        // if($response->serverError()){
        //     $error=[['Server Error'],['Please Delete All Photos to this Album']];
        //     return redirect()->route('albums.index')->with('error',$error);
        // }
        // if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
        //     return redirect()->route('home');
        // }
        if($response->status()==204){

             return redirect()->route('item.index')->with('success','Item Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('item.index')->with('error',$response->json()['message']);
        }
    }


    public function getitemvariants($id)
    {
    //   return $id;
        $session = session()->get('token');


        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url').'api/member/item/'.$id.'?include=ItemVariants');

        

        if($response->ok()){

            $itemvariants= $response->json()['data'];;

            return $itemvariants;
        }

    }

}
