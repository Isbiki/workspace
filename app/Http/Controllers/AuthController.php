<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {
    
    /**
     * Display login of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function login(){
        
    }

    /**
     * Display register of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function register(){
        $token = Session::token();
        return response()->json([
            'token' => $token
        ], 200);
    }

    /**
     * Display forget password of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function forgetPassword(){
        $title = "Forget Password";
        $description = "Some description for the page";
        return view('auth.forget_password',compact('title','description'));
    }

    /**
     * make the user able to register
     *
     * @return 
     */
    public function signup(Request $request){
        $validators=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);
        if($validators->fails()){
            return response()->json(
                [
                    'sucess' => false,
                    'error' => 'validation failed'
                ], 401);
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            $token = Session::token();
            // auth()->login($user);
            // return redirect()->intended(route('dashboard.demo_one','en'))->with('message','Registration was successfull !');     
            return response()->json([
                'success' => true,
                'user' => $user,
                'token' => $token
            ], 200);       
        }
    }

    /**
     * make the user able to login
     *
     * @return 
     */
    public function signin(Request $request){
        $validators=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validators->fails()){
            return response()->json(
                [
                    'sucess' => false,
                    'error' => 'validation failed'
                ], 401);
        }else{
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                $user = User::where('email', $request->email)->first();
                $token = Session::getId();    
                return response()->json([
                    'success' => true,
                    'user' => $user,
                    'token' => $token
                ], 200);
            }else{
                return response()->json(
                    [
                        'sucess' => false,
                        'error' => 'Login failed !Email/Password is incorrect !'
                    ], 401);
            }
        }
    }

    /**
     * make the user able to logout
     *
     * @return 
     */
    public function logout(){  
        Auth::logout(); 
        return redirect()->route('login')->with('message','Successfully Logged out !');       
    }
}