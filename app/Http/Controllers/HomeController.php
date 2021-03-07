<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Utlity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',[
            'products' => Product::all()
        ]);
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request){

        $rules = [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $this->validate($request,$rules);

        //upload photo
        if ($request->hasFile('img')){
            $path = Utlity::file_upload($request,'img','Product_images');
        }
        else {
            $path = null;
        }
        $product = new Product();
        $product->title = $request->get('title');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->image = $path;

        if ($product->save()) {

            return redirect()->route('product.create')->with('success', 'Data Added successfully Done');
        }
        return redirect()->back()->withInput()->with('failed', 'Data failed on create');

    }

    public function edit($id){
        return view('products.edit',[
            'product' => Product::find($id)
        ]);
    }

    public function update(Request $request, $id){
        $rules = [
            'title' => 'required',
            'price' => 'required',
            'description' => 'required',
            'img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $this->validate($request,$rules);

        $product = Product::find($id);
        $product->title = $request->get('title');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $path = null;
        if($request->hasFile('img')){
            if(file_exists($product->image)){
                unlink($product->image);
            }
            $path = Utlity::file_upload($request,'img','Product_images');
            $product->image = $path;
        }

        if ($product->save()) {

            return redirect()->route('product.edit', $product->id)->with('success', 'Data Updated successfully Done');
        }
        return redirect()->back()->withInput()->with('failed', 'Data failed on update');

    }

    public function destroy($id){

        $product = Product::findOrFail($id);

        if(file_exists($product->image)){
            unlink($product->image);
        }
        if($product->delete()){

            return redirect()->route('home')->with('success', 'Data Delete successfully');
        }
        return redirect()->back()->withInput()->with('failed', 'Data failed on deleting');

    }
}
