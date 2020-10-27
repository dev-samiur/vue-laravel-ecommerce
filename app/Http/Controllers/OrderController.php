<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Order;

class OrderController extends Controller
{
    public function index(Request $request){
        
        $orders= Order::where('ordered_to', Auth::user()->id)->where('status', 'pending')->get();

        return response()->json($orders);
    }

    public function store(Request $request){

        $order= new Order();

        $data= $request->all();

        

        $order->product_id= $data['data']['order'];
        $order->ordered_by= Auth::user()->id;
        $order->ordered_to= (int) $data['data']['order_to'];
        $order->status= "pending";
        $order->product_name= $data['data']['product_name'];
        $order->orderer_name= Auth::user()->name;
        
           

        try {

            $order->save();

        }catch (QueryException $e) {
            
            return response()->json('error');
        }

        return response()->json('Thanks for your order');
    }

    public function update(){

        $order_id= request('order_id');

        try {

            $order= Order::where('id', $order_id)->update(['status' => "completed"]);

        }catch (QueryException $e) {
            
            return response()->json('error');
        }

        return response()->json('success');

    }
}
