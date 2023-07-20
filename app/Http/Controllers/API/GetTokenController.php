<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetTokenController extends Controller
{
    public function register(Request $request){
        //validation for fields

        $validator = Validator($request->all(),[
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        //responce for failed validation

        if ($validator->fails()) {
            $res = [
                'error' => true,
                'message' => $validator->errors()
            ];
            return response()->json($res,200);
        }

        //checking if user exists

        $check_user = User::where('email',$request->email)
                            ->orWhere('phone',$request->phone)
                            ->first();

        if ($check_user != null) {
            if ($check_user->phone == $request->phone) {
                $msg = 'phone number already registered';
            }else{
                $msg = 'email id already registered';
            }
            return response()->json(['error' => 'true','message' => $msg],200);
        }

        //register new user

        $user = new User;
        $user->email = $request->email;
        $user->password = Myhash($request->password);
        $user->phone = $request->phone;

        //genarating token and expire time

        $token = UniqueHash($user);
        $exp = now()->addHours(12);

        $user->access_token = $token;
        $user->token_exp = $exp;
        $user->user_id = UniqueHash($user);
        $user->save();
        $res = [
            'error' => false,
            'message' => 'User Registered',
            'data' => [
                'token' => $token
            ]
        ];
        return response()->json($res,200);




    }



    public function login(Request $request){

        //setting different validation for email and phone number

        if (isset($request->email)) {
            $validator = Validator($request->all(),[
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]);
        }else{
            $validator = Validator($request->all(),[
                'phone' => 'required|numeric|digits:10',
                'password' => 'required|min:8'
            ]);
        }


        //responce for failed validation

        if ($validator->fails()) {
            $res = [
                'error' => true,
                'message' => $validator->errors()
            ];
            return response()->json($res,200);
        }

        //cheking login details

        if (isset($request->email)) {
            $check_user = User::where('email',$request->email)
                                ->where('password' ,Myhash($request->password))
                                ->first();
            $msg = 'email id or password not matched';
        }else{
            $check_user = User::where('phone',$request->phone)
                ->where('password' ,Myhash($request->password))
                ->first();
            $msg = 'phone number or password not matched';
        }


        //check user details
        if ($check_user == null) {
            $res = [
                'error' => true,
                'message' => $msg
            ];
            return response()->json($res,200);
        }

        $token = UniqueHash($check_user);
        $exp = now()->addHours(12);

        if (isset($request->email)) {
            User::where('email',$request->email)->update([
                'access_token' => $token,
                'token_exp' => $exp
            ]);
        }else{
            User::where('phone',$request->phone)->update([
                'access_token' => $token,
                'token_exp' => $exp
            ]);
        }



        $res = [
            'error' => false,
            'message' => 'Logged In',
            'data' => [
                'token' => $token
            ]
        ];

        return response()->json($res,200);
    }
}
