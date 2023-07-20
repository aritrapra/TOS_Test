<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function get(Request $request){
        $userdata = $request->get('userdata');

        $res = [
            'error' => false,
            'data' => [
                'email' => $userdata->email,
                'phone number' => $userdata->phone,
                'first name' => $userdata->first_name,
                'last name' => $userdata->last_name,
                'role' => $userdata->role

            ]
        ];
        return response()->json($res,200);

    }


    public function update(Request $request){
        //validation for fields


        $validator = Validator($request->all(),[
            'first_name' => 'min:2|max:60',
            'last_name' => 'min:2|max:60',
        ]);

        //responce for failed validation

        if ($validator->fails()) {
            $res = [
                'error' => true,
                'message' => $validator->errors()
            ];
            return response()->json($res,200);
        }

        $userdata = $request->get('userdata');
        $first_name = $userdata->first_name;
        $last_name = $userdata->last_name;
        $role = $userdata->role;




        //updating profile

        if (isset($request->role)) {

            //custom validation for role
            $roles = ['editor','writer'];

            if (!in_array($request->role,$roles)) {
                return response()->json([ 'error' => true, 'message' => 'roles can be editor or writer only'],200);
            }else{
                $role = $request->role;
            }
        }

        if (isset($request->first_name)) {
            $first_name = $request->first_name;
        }

        if (isset($request->last_name)) {
            $last_name = $request->last_name;
        }


        User::where('access_token',$request->token)->update([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => $role
        ]);

        return response()->json([ 'error' => false, 'message' => 'profile updated'],200);





    }

}
