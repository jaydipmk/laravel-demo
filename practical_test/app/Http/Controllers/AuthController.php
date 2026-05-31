<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    //


    public function login(){
        return view('login');
    }

    public function loginAction(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:user,email',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(array('status' => false, 'error' => $validator->errors()));
        }

        $params['email']    = $request->email;
        $params['password'] = $request->password;
        if(Auth::guard('user')->attempt($params)){

            $param['user_id'] = Auth::guard('user')->user()->id;

            $login = new LoginHistory();
            $insert = $login->fill($param)->save();
//            LoginHistory::create($param);

            return response()->json([
                'status' => true,
                'message' => "Login successfully"
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => "The password you have entered is incorrect !"
            ]);
        }
    }

    public function register(){
        return view('register');
    }

    public function registerAction(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'first_name' => 'required|alpha',
            'last_name' => 'required||alpha',
            'email' => 'required|email|unique:user',
            'password' => 'required|confirmed|min:8',
            'birth_date' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json(array('status' => false, 'error' => $validator->errors()));
        }

        $imageName = time().'.'.$request->image->extension();

        $params = $request->except('password','password_confirmation','_token','image');
        $params['password'] = Hash::make( $request->password);
        $params['image'] = $imageName;

        $user = User::create($params);

        if($user) {
            $request->image->move(public_path('images'), $imageName);
            return response()->json([
                'status' => true,
                'message' => "User created sucessfully"
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => "something went wrong"
            ]);
        }
    }
}
