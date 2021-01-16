<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // for Database Operation...
use Illuminate\Support\Facades\Storage; //for Storage Manage like File delete from storage...


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$products = Product::latest()->paginate(5);
        
        // print_r((request()->input('page', 1) - 1) * 5);
        // $i = (request()->input('page', 1) - 1) * 5;
        // echo "<pre>";
        // print_r(compact('products','i'));


        return view('products.index',compact('products'))
            ->with('i', (request()->input('page', 1) - 1) * 5);*/ //with Paggination...

        // $products = Product::distinct()->get();
        $products = Product::get();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'img' => 'required | mimes:jpeg,jpg,png',
        ]);
        // print_r($request->all());
        // $data = new ProductController;
        if($request->hasFile('img')){
            $file = $request->File('img');
            $original_name = $file->getClientOriginalName();  
            $file_ext = $file->getClientOriginalExtension();  
            $destinationPath = 'uploads/products';
            $file_name = "product".time().uniqid().".".$file_ext;
            // $path = $request->img->store('uploads'); 

            $file->move($destinationPath,$file_name);  
            echo $image_url = $destinationPath."/".$file_name;  
        }  
        $request->request->add(['image_url' => $image_url]);
        print_r($request->all());            
        exit;
        Product::create($request->all());
     
        return redirect()->route('admin.products.index')
                        ->with('insert success','Product created successfully.');
        
        // return redirect()->action([ProductController::class, 'index']) 
        // ->with('success','Product created successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {   
        return view('admin.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'img' => 'mimes:jpeg,jpg,png',
        ]);
        if($request->hasFile('img')){
            $oldproduct = Product::find($product);
            $olddata = compact('oldproduct');
            echo $oldImgPath = $product['image_url']; 
            // exit;
            // File::Delete($oldImgPath);
            // Storage::disk('public')->delete('/'.$oldImgPath); //for Delete specific file from storage...

            $file = $request->File('img');
            $original_name = $file->getClientOriginalName();  
            $file_ext = $file->getClientOriginalExtension();  
            $destinationPath = 'uploads/products';
            $file_name = "product".time().uniqid().".".$file_ext;
            // $path = $request->img->store('uploads'); 

            $file->move($destinationPath,$file_name);  
            echo $image_url = $destinationPath."/".$file_name;  
            $request->request->add(['image_url' => $image_url]);
        }
    
        $product->update($request->all());
    
        return redirect()->route('admin.products.index')
                        ->with('update success','Product updated successfully');
        
        // return redirect()->action([ProductController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    
        return redirect()->route('admin.products.index')
                        ->with('delete success','Product deleted successfully');
    }
}
