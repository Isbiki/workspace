<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {
    
    /**
     * Display user members of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request){
        $searchKey = $request->input('search');
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.name', 'like', '%'.$searchKey.'%')
            ->orwhere('users.email', 'like', '%'.$searchKey.'%')
            ->select('users.*', 'roles.name as role_name')
            ->orderby('users.name')
            ->get();
    
        if($users->isNotEmpty()){
            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
    }
    
    public function store(Request $request){

        $validators=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
        ]);
        if($validators->fails()){
            return response()->json(
                [
                    'sucess' => false,
                    'message' => 'validation failed'
                ]);
        }else{
            $defaultAvatar = '/src/assets/images/users/dummy-avatar.jpg';
            $roleId = DB::table('roles')->where('name', '=', $request->role)->pluck('id')->first();  

            $user = new User();
            if($roleId) $user->role_id = $roleId;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->avatar = $defaultAvatar;
            if($user->save()){
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully created',
                    'user' => $user,
                ]);     
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Can not save.',
                ]);     
            }
        }
    }

    public function update(Request $request, $id)  
    {  
        // Validate the incoming request data  
        $request->validate([  
            'role'=>'required',
        ]);  
        $roleId = DB::table('roles')->where('name', '=', $request->role)->pluck('id')->first();  
        $user = User::findOrFail($id);  
        $user->role_id = $roleId;
        if($user->save()){
            return response()->json(['success' => true, 'message' => 'User updated successfully!', 'user' => $user]);
        }
        else{
            return response()->json(['success' => false, 'message' => 'Can not save updated user', 'user' => $user]);
        }
        

        // Optionally return a response  
          
    }  

    public function destroy($id) 
    {  
        // Find the user or resource by ID  
        $user = User::find($id);  

        // Check if the resource exists  
        if (!$user) {  
            return response()->json(['success' => false, 'message' => 'User not found']);  
        }  

        // Delete the resource  
        $user->delete();  

        // Return a response  
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);  
    }  
    
}