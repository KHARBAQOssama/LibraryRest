<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['roles'=>Role::all()]);   
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json([
            'role'=> [
                'name'=>$role->name,
                'permissions' => $role->permissions
                ]
            ]);   
    }

    public function assignPermissions(Request $request,int $id){
        
        if(!JWTAuth::user()->hasPermission('changePermissions')){
            return response()->json(['message'=>'you are not allowed to do this operation']); 
        }
        
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'error' => 'Role not found.'
            ], 404);
        }

        $request->validate([
            'permissions' => 'required|array',
        ]);

        $role->permissions()->detach();

        $permissions = $request->input('permissions');
        foreach ($permissions as $permission) {
            $role->permissions()->attach($permission);
        }

        return response()->json([
            'message' => 'Permissions have been assigned successfully.'
        ], 200);
    }
}
