<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Product;
use Exception;
use SebastianBergmann\Environment\Console;

class ProductController extends Controller
{
    public function index(Request $request){

        // $data= request('productsRetreiveInfo');

        // if($data == 'all')
        // {
        //     $products= Product::all();
        // }

        // else if($data == 'seller')
        // {
        //     $products= Product::where('user', Auth::user()->id)->get();
        // }
        // else
        // {
        //     $products= Product::where('catagory', $data)->get();
        // }

        try{
            $products= Product::all();
        } catch(Exception $e) {
            return response()->json($e->getMessage()); 
        }
        
        return response()->json($products);
        
        }

    public function show($id){

        $product= Product::findOrFail($id);
        
    }

    public function store(Request $request){
        
          $validator = Validator::make($request->all(), [
             'name' => 'required|max:50',
             'price' => 'required',
             'catagory' => 'required',
             'description' => 'required',
             'image' => 'required|file|image|',
          ]);

          if ($validator->fails()) {
              return response()->json(['error' => $validator->errors()]);
         }

        $data= $request->all();

        $name  = $data['image']->getClientOriginalName();
        $picture   = date('His').'-'.$name;
        
        
        $result= $data['image']->move('images', $picture);

        if($result)
        {
            //$userId = auth()->guard('api')->user();
            $userId = Auth::user()->id;
            $data += ['user' => $userId];
            $data['image']= $picture;
            
            try {

                $product = Product::create($data);
    
            }catch (QueryException $e) {
                
                return response()->json(['error' => 'Error']);
            }
        }
        else
            return response()->json(['error' => 'Error']);
        
        return response()->json(['success' => 'Product added successfully']);
    }

    public function destroy(){

        $id= request('id');

         $product= Product::findOrFail($id);

         $product->delete();

    }
}
