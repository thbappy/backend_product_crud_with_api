<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Utlity;
use Illuminate\Http\Request;
use \Validator;

class ProductController extends Controller
{
    public function index(){

        $product = ProductResource::collection(Product::all());

        if ($product->count() == 0) {
            $response = [
                'success' => 'false',
                'data' => '',
                'message' => " Sorry!! Data List Empty",
            ];
            return response()->json($response,400);
        }

        $response = [
            'success' => 'true',
            'data' => $product,
            'message' => " Product List",
        ];
        return response()->json($response,200);
    }

    public function create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        if($validator->fails()){
            $response = [
                'success' => 'false',
                'data' => 'Validation Error.',
                'message' => $validator->errors(),
            ];
            return response()->json($response,400);
        }

        //upload photo
        if ($request->hasFile('image')){
            $path = Utlity::file_upload($request,'image','Product_images');
        }
        else {
            $path = null;
        }

        $product = Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path==true ? $path : 'default.jpg',
        ]);

        $response = [
            'success' => 'true',
            'data' => $product,
            'message' => 'Data Successfully Stored',
        ];
        return response()->json($response,200);
    }

    public function destroy($id){

        $result = Product::find($id);
        if(file_exists($result->image)){
            unlink($result->image);
        }
        $data   = $result->delete();
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => "Data Delete Sucessfully",
        ];

        return response()->json($response, 200);

    }
}
