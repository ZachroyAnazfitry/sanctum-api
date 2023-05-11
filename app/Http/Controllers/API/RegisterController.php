<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
// use Validator;
use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController
{
    // create register function to handle registration with validation, error message , and create new user

    public function register(Request $request)
    {
        // validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            // 'c_password' => 'required|same:password',
        ]);
        
        // if failed, return error response
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);  // hashed using bcrypt for security

        // create a new user
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }


    // create a login method
    public function login(Request $request)
    {
        /**
         * use Auth facade
         * verify user credentials with attempt() method
         * 
         */
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); // retrieve user
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            
            // display success message after login succesfully
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 

            // error response
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
}
