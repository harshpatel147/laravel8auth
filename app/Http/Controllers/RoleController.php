<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // for Database Operation...

class RoleController extends Controller
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
        $roles = Role::get();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
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
            'rolename' => 'required',
            'description' => 'required',
        ]);
        print_r($request->all());
        Role::create($request->all());
     
        return redirect()->route('admin.roles.index')
                        ->with('insert success','Role created successfully.');
        
        // return redirect()->action([ProductController::class, 'index']) 
        // ->with('success','Product created successfully.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {   
        return view('admin.roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        
        $request->validate([
            'rolename' => 'required',
            'description' => 'required',
        ]);
    
        $role->update($request->all());
    
        return redirect()->route('admin.roles.index')
                        ->with('update success','Role updated successfully');
        
        // return redirect()->action([ProductController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
    
        return redirect()->route('admin.roles.index')
                        ->with('delete success','Role deleted successfully');
    }
}
