<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchKey = $request->search;
        $roles = DB::table('roles')->where('name', 'like', '%'.$searchKey.'%')->get();
        if($roles){
            return response()->json([
                'success' => true,
                'roles' => $roles
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'error' => 'Role not found'
            ]);
        }
    }
    public function store(Request $request){  
        $validators = Validator::make($request->all(), [  
            'name' => 'required|unique:roles,name',  
        ]);  
    
        if ($validators->fails()) {  
            return response()->json([  
                'success' => false,  
                'message' => 'Validation failed',  
                'errors' => $validators->errors(), // Include specific validation errors  
            ]); 
        }  
    
        // Using `create` method for better readability and efficiency  
        $role = Role::create(['name' => $request->name]);  
    
        if ($role) {  
            return response()->json([  
                'success' => true,  
                'message' => 'Successfully created',  
                'role' => $role  
            ], 201); // Return 201 Created status  
        } else {  
            return response()->json([  
                'success' => false,  
                'message' => 'Cannot save.',  
            ], 500); // Return 500 Internal Server Error status if save fails  
        }  
    }  

    public function update(Request $request, $id)  
    {  
        $request->validate([  
            'name' => 'required|unique:roles,name,' . $id, // Allow the current role's name  
        ]);  

        $role = Role::findOrFail($id);  
        
        // Update the name attribute  
        $role->name = $request->name;  

        if ($role->save()) {  
            return response()->json(['success' => true, 'message' => 'Role updated successfully!', 'role' => $role], 200); // HTTP 200 OK  
        } else {  
            return response()->json(['success' => false, 'message' => 'Cannot save updated role.'], 500); // HTTP 500 Internal Server Error  
        }  
    }  

    public function destroy($id)   
{  
    try {  
        $role = Role::findOrFail($id);  
        // Check if any users are using this role  
        if ($role->users()->count() > 0) {  
            return response()->json(['success' => false, 'error' => 'Cannot delete role. There are users associated with this role.'], 400); // HTTP 400 Bad Request  
        }  

        // Delete the resource  
        $role->delete();  

        return response()->json(['success' => true, 'message' => 'Role deleted successfully'], 200);   
    } catch (ModelNotFoundException $e) {  
        return response()->json(['success' => false, 'message' => 'Role not found'], 404);  
    } catch (\Exception $e) {  
        return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);  
    }  
}  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
