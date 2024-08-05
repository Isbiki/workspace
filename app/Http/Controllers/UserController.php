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
            ->orderby('users.created_at', 'desc')
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
        try {  
            $validators = Validator::make($request->all(), User::rules());  
            if ($validators->fails()) {  
                return response()->json([  
                    'success' => false,  
                    'message' => 'Validation Error',   
                ]);  
            } else {  
                $user = User::create($request->all());  
                
                if ($user) {  
                    return response()->json([  
                        'success' => true,  
                        'message' => 'Successfully created',  
                        'user' => $user,  
                    ]);  
                } else {  
                    return response()->json([  
                        'success' => false,  
                        'message' => 'Cannot save.',  
                    ]);  
                }  
            }  
        } catch (\Throwable $e) {  
            \Log::error($e); // Log the error  
            return response()->json([  
                'success' => false,  
                'message' => 'An error occurred',  
                'error' => $e->getMessage(),  
            ], 500);  
        }  
        
    }

    public function update(Request $request, $id)  
    {  
        $user = User::findOrFail($id);  
        $user->fill($request->all());
        if($user->save()){
            return response()->json(['success' => true, 'message' => 'User updated successfully!', 'user' => $user]);
        }
        else{
            return response()->json(['success' => false, 'message' => 'Can not save updated User', 'user' => $user]);
        }
          
    }  

    public function destroy($id) 
    {  
        try {  
            $user = User::findOrFail($id);  
            $user->delete();  
            return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);   
        } catch (ModelNotFoundException $e) {  
            return response()->json(['success' => false, 'message' => 'User not found'], 404);  
        } catch (\Exception $e) {  
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);  
        } return response()->json(['success' => true, 'message' => 'User deleted successfully']);  
    }  
    
}