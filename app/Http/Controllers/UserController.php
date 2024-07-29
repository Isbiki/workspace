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
    public function index(){
        $users = DB::table('users')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->select('users.*', 'roles.name as role_name')
        ->get();

        if($users){
            return response()->json([
                'success' => true,
                'data' => $users
            ], 200);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Role not found'
            ], 401);
        }
    }
    
    /**
     * Display user grid of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function grid(){
        $title = "User Grid";
        $description = "Some description for the page";
        return view('pages.applications.user.grid',compact('title','description'));
    }

    /**
     * Display user list of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function list(){
        $title = "User List";
        $description = "Some description for the page";
        return view('pages.applications.user.list',compact('title','description'));
    }

    /**
     * Display user grid style of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function gridStyle(){
        $title = "User Grid Style List";
        $description = "Some description for the page";
        return view('pages.applications.user.grid_style',compact('title','description'));
    }

    /**
     * Display user group of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function userGroup(){
        $title = "User Group List";
        $description = "Some description for the page";
        return view('pages.applications.user.user_group',compact('title','description'));
    }

    /**
     * Display user add of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function add(){
        $title = "User Add";
        $description = "Some description for the page";
        return view('pages.applications.user.add',compact('title','description'));
    }

    /**
     * Display user table of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function table(){
        $title = "User Data Table";
        $description = "Some description for the page";
        return view('pages.applications.user.data_table',compact('title','description'));
    }
    public function getAllUsers(){
        
    }
}