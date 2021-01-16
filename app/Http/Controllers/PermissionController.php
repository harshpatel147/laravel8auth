<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // for Database Operation...

class PermissionController extends Controller
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
        $permissions = Permission::get();
        return view('admin.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
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
            'controller' => 'required',
            'method' => 'required',
        ]);
        // print_r($request->all());
        Permission::create($request->all());
     
        return redirect()->route('admin.permissions.index')
                        ->with('insert success','Permission created successfully.');
        
        // return redirect()->action([ProductController::class, 'index']) 
        // ->with('success','Product created successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {   
        return view('admin.permissions.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        
        $request->validate([
            'name' => 'required',
            'controller' => 'required',
            'method' => 'required',
        ]);
    
        $permission->update($request->all());
    
        return redirect()->route('admin.permissions.index')
                        ->with('update success','Permission updated successfully');
        
        // return redirect()->action([ProductController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
    
        return redirect()->route('admin.permissions.index')
                        ->with('delete success','Permission deleted successfully');
    }
}
