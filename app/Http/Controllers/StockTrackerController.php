<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StockTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$page = 1)
    {
        //

           //  echo $page;

           $token = session()->get('token');
           try{
   
               $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/stockTracker?page='.$page);
   
               $response = json_decode($call->getBody()->getContents(), true);
               //  return $response;
           }catch (\Exception $e){
               //buy a beer
   
   
           }
            $stocktracker = $response['data'];
            $pagination = $response['meta']['pagination'];
   
             $lastpage = $pagination['total_pages'];
   
               return view(
                   'stock_tracker_list', compact(
                       'stocktracker', 'pagination','lastpage'
                   )
           );
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

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariant');

            $ivresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $variants = $ivresponse['data'];



         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers');

            $sresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $suppliers = $sresponse['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

            $vresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendors = $vresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

            $vresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorstores = $vresponse['data'];



         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/prodSubCat');

            $scresponse = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $subcategories = $scresponse['data'];


         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariantGroup');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $itemvariantgroup = $response['data'];




         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confVendorCat');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $vendorcate = $response['data'];

         try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confSupplierCat');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $suppliercategories = $response['data'];

        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confOrderType');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $ordertype = $response['data'];


        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confPaymentStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
        $paymentstatus = $response['data'];



       try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

            $response = json_decode($call->getBody()->getContents(), true);
            //  return $response;
        }catch (\Exception $e){
            //buy a beer


        }
         $statuses = $response['data'];


            return view(
                'create_stock_tracker', compact(
                    'items','variants','suppliers','statuses','vendors','subcategories','itemvariantgroup','suppliercategories','vendorstores','vendorcate','ordertype','paymentstatus'
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


        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->post(config('global.url').'api/stockTracker',

        [
            "item_id"=>$request->item_id,

            "variant_id"=>$request->variant_id,

            "supplier_id"=>$request->supplier_id,

            "order_ref"=>$request->order_ref,

            "order_date"=>$request->order_date,

            "purchase_price"=>$request->purchase_price,

            "stock_quantity"=>$request->stock_quantity,

            "comments"=>$request->comments,

            "vendor_id"=>$request->vendor_id,
            "vendor_store_id"=>$request->vendor_store_id,
            "order_type_id"=>$request->order_type_id,

            "MRP"=>$request->MRP,
            "selling_price"=>$request->selling_price,
            "payment_date"=>$request->payment_date,


            "total_amount"=>$request->total_amount,
            "payment_status_id"=>$request->payment_status_id,
            "status_id"=>$request->status_id

        ]);
        // dd($request->all());

        // dd($response);
        // echo $response->status();exit;

        if($response->status()===201){

            return redirect()->route('stock_tracker.create')->with('success','Stock Tracker Created Successfully!');
        }else{
            // var_dump($response);exit;
          // return dd($response->json());
            $request->flash();
            return redirect()->route('stock_tracker.create')->with('error',$response['errors']);
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


        $token = session()->get('token');

        try{

            $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/stockTracker/'.$id);

            $response = json_decode($call->getBody()->getContents(), true);

        }catch (\Exception $e){



        }
         $stocktracker = $response['data'];



            return view(
                'view_stock_tracker', compact(
                    'stocktracker'
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

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/itemVariant');

    $ivresponse = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
 $variants = $ivresponse['data'];




 try{

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendors');

    $ivresponse = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
 $vendor = $ivresponse['data'];


 try{

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/vendorStores');

    $ivresponse = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
 $vendorstore = $ivresponse['data'];



 try{

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/suppliers');

    $sresponse = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
 $suppliers = $sresponse['data'];

 try{

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confOrderType');

    $response = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
$ordertype = $response['data'];


try{

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confPaymentStatus');

    $response = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
$paymentstatus = $response['data'];

try{

    $call = Http::withToken($token)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->get(config('global.url') . '/api/confStatus');

    $response = json_decode($call->getBody()->getContents(), true);
    //  return $response;
}catch (\Exception $e){
    //buy a beer


}
 $statuses = $response['data'];

         $smresponse=Http::withToken($token)->get(config('global.url').'/api/stockTracker/'.$id);


         if($smresponse->ok()){

            $stock_tracker=   $smresponse->json()['data'];

            return view('edit_stock_tracker', compact(
                'stock_tracker','items','variants','suppliers','statuses','vendor','vendorstore','ordertype','paymentstatus'
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
      
        $response = Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->put(config('global.url').'/api/stockTracker/'.$id, 
        
        [
            "_method"=> 'PUT',
                    
            "item_id"=>$request->item_id,

            "variant_id"=>$request->variant_id,

            "supplier_id"=>$request->supplier_id,

            "order_ref"=>$request->order_ref,

            "order_date"=>$request->order_date,

            "purchase_price"=>$request->purchase_price,

            "stock_quantity"=>$request->stock_quantity,
            "vendor_id"=>$request->vendor_id,
            "vendor_store_id"=>$request->vendor_store_id,
            "order_type_id"=>$request->order_type_id,
            "total_amount"=>$request->total_amount,

            "MRP"=>$request->MRP,
            "selling_price"=>$request->selling_price,
            "payment_date"=>$request->payment_date,
            "payment_status_id"=>$request->payment_status_id,
            "comments"=>$request->comments,

            "status_id"=>$request->status_id
        ]
        
      );

        
        if($response->headers()['Content-Type'][0]=="text/html; charset=UTF-8"){
            return redirect()->route('home');
        }
        if($response->status()===200){
            return redirect()->back()->with('success','Stock Tracker Updated Successfully!');
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
        //


        $session = session()->get('token');

        $response=Http::withToken($session)->withHeaders(['Accept'=>'application/vnd.api.v1+json','Content-Type'=>'application/json'])->delete(config('global.url').'api/stockTracker/'.$id);

        if($response->status()==204){

             return redirect()->route('stock_tracker.index')->with('success','Stock Tracker Deleted Sucessfully !..');
        }
        else{

          //  dd($response);
             return redirect()->route('stock_tracker.index')->with('error',$response->json()['message']);
        }




    }
}
