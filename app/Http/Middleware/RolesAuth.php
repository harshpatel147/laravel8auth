<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\DB; // for Database Operation...


class RolesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // get user role permissions
        $role = Role::findOrFail(auth()->user()->role_id);
        // print_r($role->toarray());
        $role_id = $role->id;
        echo "<br><h1>".$role_id."</h1>";
        if(!empty($role_id)){
            $permissions_id = PermissionRole::where('role_id', $role_id)->get();
            if(!empty($permissions_id)){
                // print_r($permissions_id->toarray());
                $data = array();    
                // echo "Permission List";
                // echo "<br>";
                foreach ($permissions_id as $permission){
                    // echo $permission['permission_id'];
                    $data[] = Permission::where('id', $permission['permission_id'])->get(); //return Permission list using Role Id...
                }
                // echo "<pre>";
                // print_r($data);  
                //echo "<br>";
                
                // get requested action
                $actionName = class_basename($request->route()->getActionname()); //GET CONTROLLER AND METHOD NAME USING REQUESTED URL...
                // echo $actionName;
                //echo "<br>";

                // check if requested action is in permissions list
                foreach ($data as $permissions) {
                    // echo "<pre>";
                    // print_r($permissions);
                    // exit;
                    if(!empty($permissions)){
                        foreach ($permissions as $permission){
                            $_namespaces_chunks = explode('\\', $permission->controller);
                            $controller = end($_namespaces_chunks);
                            // echo "<br><br>";
                            // echo $controller.'@'.$permission->method;
                            if ($actionName == $controller . '@' . $permission->method)
                            {
                                // authorized request
                                echo "<h1>".$actionName."Successfully Matched</h1>";
                                // exit;
                                return $next($request);
                            }
                        }
                    }
                }

            }else{
                return response('Unauthorized Action1', 403);
            }
        }
        return response('Unauthorized Action2', 403);

        exit;


            /*$permissions_id = PermissionRole::where('role_id', $role_id)->get();
            // print_r($permissions_id->toarray());
            foreach ($permissions_id as $permission){
                echo "<br>";
                echo $permission['permission_id'];
                $permissions = Permission::where('id', $permission['permission_id'])->get();
                print_r($permissions->toarray()); 
            }

        
            // exit;
            // get requested action
            echo $actionName = class_basename($request->route()->getActionname());
            // check if requested action is in permissions list
            if(!empty($permissions_id) || !empty($role_id) || !empty($permissions)){
            foreach ($permissions as $permission)
            {
                $_namespaces_chunks = explode('\\', $permission->controller);
                $controller = end($_namespaces_chunks);
                if ($actionName == $controller . '@' . $permission->method)
                {
                    // authorized request
                    return $next($request);
                }
            }
        // none authorized request
        return response('Unauthorized Action', 403);
           // return $next($request);
        }else{

        }*/
    }
}
