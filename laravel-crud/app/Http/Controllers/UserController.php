<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Http\Traits\BaseTrait;
use App\Models\Address;

class UserController extends Controller

{
    use BaseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
        
            $response       = User::select('*');
            $count          = $response->count();
            $responseData   = $response->with('addresses')->orderBy('id','DESC')->take($request->length)->skip($request->start)->get();
        
            return DataTables::make($responseData)
                ->addIndexColumn()
                ->addColumn('name',function ($row){
                    return $row->name;
                })
                ->addColumn('email',function ($row){
                    return $row->email;
                })
                ->addColumn('phone',function ($row){
                    return $row->phone;
                })
                ->addColumn('city',function ($row){
                    return $row->city;
                })
                ->addColumn('state',function ($row){
                    return $row->state;
                })
                ->addColumn('address',function ($row){
                    $html = '';
                   if($row->addresses->isNotEmpty()){
                        foreach($row->addresses as $address){
                            $html .= $address->address.'</br>';
                        }
                    }
                    return $html;
                })
                ->addColumn('action',function ($row){
                    return '<button type="submit" class="btn btn-warning editUser" data-id="'.$row->id.'">edit</button>
                            <button type="submit" class="btn btn-danger deleteUser" data-id="'.$row->id.'">Delete</button>';
                })
                ->rawColumns(['name','email', 'phone','city', 'state','address','action'])
                ->with(['recordsFiltered'=> $count,'recordsTotal' => $count])
                ->skipPaging()
                ->make();
        }
        return view('users.index');
    }

    // add user
    public function addUser(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'addresses' => 'required|array|min:1',
            'addresses.*' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(array('status' => false, 'error' => $validator->errors()));
        }

        $user = User::create($request->all());
    
        foreach ($request->addresses as $address) {
            $user->addresses()->create(['address' => $address]);
        }

        return $this->sendSuccess("User created sucessfully");
    }

  
    // GET USER
    public function getUser(Request $request){
        $validator = Validator::make($request->all(),[
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        if($validator->fails()){
            return $this->sendValidationError($validator->errors());
        }

        $response = User::where('id',$request->user_id)->with('addresses')->first();
        if(!empty($response)){
            return $this->sendResponse("user details",$response);
        }else{
            return $this->sendError("Failed to get user details !");
        }
    }

     // UPDATE USER 
     public function updateUser(Request $request, User $user){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required',
            'country' => 'required',
            'city' => 'required',
            'state' => 'required',
            'addresses' => 'required|array|min:1',
            'addresses.*' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(array('status' => false, 'error' => $validator->errors()));
        }

        $params = $request->except('_token','id','addresses');
        $update = User::where('id',$request->id)->update($params);

        foreach ($request->addresses as $address) {

            $param1['address'] = $address;
            $update = Address::where('user_id',$request->id)->update($param1);
        }

        if($update){
            return $this->sendSuccess("user has been updated successfully.");
        }else{
            return $this->sendError("Failed to update User !");
        }
    }

    // DELETE USER
    public function destroy(Request $request)
    {
        $remove = User::where('id',$request->user_id)->delete();
        if($remove){
            return $this->sendSuccess("User has been removed");
        }else{
            return $this->sendError("Failed to remove user !");
        }
    }
}
