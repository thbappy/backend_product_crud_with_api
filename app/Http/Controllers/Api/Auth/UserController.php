<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            $response = [
                'success' => 'false',
                'data' => 'Validation Error.',
                'message' => $validator->errors(),
            ];
            return response()->json($response,400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        $response = [
            'success' => 'true',
            'data' => $user,
            'token' => $token,
            'message' => 'Registration Successfully Done',
        ];
        return response()->json($response,200);
    }

    public function login(Request $request){

        $input = $request->all();

        $data = null;

        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            $response = [
                'success' => 'false',
                'data' => 'Validation Error.',
                'message' => $validator->errors(),
            ];
            return response()->json($response,400);
        }

        $is_exit = User::where('email',$request->email)->first();

        if(is_null($is_exit)){

            $response = [
                'success' => 'false',
                'data' => '',
                'message' => "Sorry!! Email Not Match",
            ];
            return response()->json($response,400);
        }
        else {
            if(Hash::check($request['password'],$is_exit->password)){
                $response = [
                    'success' => 'true',
                    'message' => "Successfully Logged in",
                    'data'    => $is_exit,
                    'token'  =>$is_exit->createToken('LaravelAuthApp')->accessToken,

                ];
                return response()->json($response,200);
            }
            else {
                $response = [
                    'success' => 'false',
                    'data' => "",
                    'message' => "Phone or password is wrong.",
                ];
                return response()->json($response,400);
            }
        }

    }

    public function logout(Request $request){
        $input = $request->all();

        $status_code =200;
        $data = null;

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            $response = [
                'success' => 'false',
                'data' => 'Validation Error.',
                'message' => $validator->errors(),
            ];
            return response()->json($response,400);
        }

        $token = $request->user()->token();
        $token->revoke();
        $message = 'You have been succesfully logged out!';
        return $data = [
            'status_code' => $status_code,
            'message' => $message,
            'data' => $request->all(),
        ];

    }
}
