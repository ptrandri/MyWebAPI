<?php

namespace App\Http\Controllers\API;
   
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Users as UsersResource;
use App\Http\Controllers\API\BaseController as BaseController;
   
class MasterdataUserController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth.sanctum');
    }

    public function index()
    {
        $users = User::all();
        return $this->sendResponse(UsersResource::collection($users), 'Users fetched.');
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);   
        return $this->sendResponse($user["email"], 'User created successfully.');
    
    }

    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return $this->sendError('Users does not exist.');
        }
        return $this->sendResponse(new UsersResource($user), 'Users fetched.');
    }


}
