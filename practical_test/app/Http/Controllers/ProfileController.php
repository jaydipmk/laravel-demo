<?php

namespace App\Http\Controllers;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $loginHistory = LoginHistory::where('user_id', Auth::guard('user')->user()->id)->take(1)->skip(1)->orderBy('id', 'DESC')->first();
        $data = array();
        if($loginHistory){
            $data['last_login'] = Carbon::make($loginHistory['created_at'])->format('d M Y h:i:s A');
        }
        return view('dashboard', $data);
    }

    public function getProfile()
    {
        $data['user'] = User::where('id', Auth::guard('user')->user()->id)->first();
        return view('edit-profile', $data);
    }


    public function updateProfile(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'first_name' => 'required|alpha',
            'last_name' => 'required||alpha',
            'email' => ['required', 'email', Rule::unique('user', 'email')->whereNot('id', Auth::guard('user')->user()->id)],
            'birth_date' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(array('status' => false, 'error' => $validator->errors()));
        }

        $params = $request->except('_token','image');

        if($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $params['image'] = $imageName;
        }

        $update = User::where("id", Auth::guard('user')->user()->id)->update($params);

        if($update) {
            return response()->json([
                'status' => true,
                'message' => "User updated successfully"
            ], 200);
        }else {
            return response()->json([
                'status' => false,
                'message' => "something went wrong"
            ]);
        }
    }
}
