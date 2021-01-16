<?php

namespace App\Http\Controllers;

use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // for Database Operation...

class PermissionRoleController extends Controller
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
        // $rolepermissions = PermissionRole::get();


            /*$rolepermissions = DB::table('permissions')
                        ->join('permission_role', 'permission_role.permission_id', '=', 'permissions.id')
                        ->select('permissions.name', 'permission_role.*')
                        ->get();
            foreach ($rolepermissions as $value) {
                echo "<br>";
                echo $value->role_id;
                $rolepermissions = DB::table('permission_role')
                ->join('roles', 'roles.id', '=', 'permission_role.permission_id')
                // ->join('roles', 'roles.id', '=', 'permission_role.role_id')
                ->select('roles.name', 'permission_role.*')
                ->where('role_id', '=', $value->role_id)
                ->get();

            }
        print_r($rolepermissions->toarray());*/

        $rolepermissions = DB::table('permission_role')
                ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                ->join('roles', 'roles.id', '=', 'permission_role.role_id')
                ->select('permission_role.*', 'permissions.name', 'roles.rolename')
                ->get();
                // ->groupBy('role_id'); //not perfect
        // echo "<pre>";
        // print_r($rolepermissions->toarray());

        $roles = DB::table('roles')->get();
        // echo "<pre>";
        // print_r($roles->toarray());
        // exit;
        return view('admin.rolepermissions.index',compact('rolepermissions'), compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $permissions = DB::table('permissions')->get();
        $roles = DB::table('roles')->get();
        
        $rolepermissions = DB::table('permission_role')
                                ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                                ->join('roles', 'roles.id', '=', 'permission_role.permission_id')
                                ->select('permission_role.*', 'permissions.name', 'roles.rolename')
                                ->get();
        // echo "<pre>";
        // print_r($rolepermissions->toarray());
        
        $i = 0;
        $exits = array();
        foreach ($roles as $val) {
            // echo $val->id;
            // echo $val->rolename;
            $querydata = DB::table('permission_role')
                            ->select('permission_role.*')
                            ->where('role_id', '=', $val->id)
                            ->get();
            if(!empty($querydata->toarray())){
                ++$i;
                $exits[$i] = $val->id;
            }
        }
        // print_r($exits);
        $all['roles'] = $roles;
        $all['permissions'] = $permissions;
        $all['roleexits'] = $exits;
        // print_r($all);
        // exit;
        return view('admin.rolepermissions.create', compact('rolepermissions'), compact('all'));
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
            'role_id' => 'required',
            'permission_id' => 'required',
        ]);
        print_r($request->all());
        $role_id = $request->input('role_id');
        $permission_IDs = $request->input('permission_id');
        // $sql = 'insert into permission_role(permission_id, role_id) values('$firstname','$lastname','$email')'
        foreach ($permission_IDs as $value) {
            $request->merge([
                'permission_id' => $value,
            ]);
            // echo "<br>";
            // print_r($request->all());
            PermissionRole::create($request->all());
        }
     
        return redirect()->route('admin.rolepermissions.index')
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
    public function edit(Role $rolepermission)
    {   
        $permissions = DB::table('permissions')->get();
        $roles = DB::table('roles')->get();

        
        $rolepermissions = DB::table('permission_role')
                ->join('permissions', 'permissions.id', '=', 'permission_role.permission_id')
                ->join('roles', 'roles.id', '=', 'permission_role.role_id')
                ->select('permission_role.*', 'permissions.name', 'roles.rolename')
                ->where('role_id', '=', $rolepermission->id)
                ->get();

        // echo "<pre>";
        // print_r($permissions);
        // print_r($rolepermissions);

        $i = 0;
        $permissionexits = array();
        foreach ($permissions as $val) {
            // echo $val->id;
            // echo $val->rolename;
            $querydata = DB::table('permission_role')
                            ->select('permission_role.*')
                            ->where('permission_id', '=', $val->id)
                            ->where('role_id', '=', $rolepermission->id)
                            ->get();
            if(!empty($querydata->toarray())){
                ++$i;
                $permissionexits[$i] = $val->id;
            }
        }
        
        // print_r($permissionexits);
        $all['permissions'] = $permissions;
        $all['roles'] = $roles;
        $all['rolepermissions'] = $rolepermissions;
        $all['permissionexits'] = $permissionexits;
        $all['roleexits'] = $rolepermission->toarray();
        // echo "<pre>";
        // print_r($all);
        // exit;

        return view('admin.rolepermissions.edit',compact('rolepermission'), compact('all'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            // 'permission_id' => 'required',
        ]);
        print_r($request->all());
        $role_id = $request->input('role_id');
        $permission_IDs = $request->input('permission_id');
        DB::table('permission_role')->where('role_id', '=', $role_id)->delete();
        print_r($request->all());
        // $sql = 'insert into permission_role(permission_id, role_id) values('$firstname','$lastname','$email')'
        if(!empty($permission_IDs)){
        foreach ($permission_IDs as $value) {
            $request->merge([
                'permission_id' => $value,
            ]);
            // echo "<br>";
            // print_r($request->all());
            PermissionRole::create($request->all());
        }}
    
        // $permission->update($request->all());
    
        return redirect()->route('admin.rolepermissions.index')
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
