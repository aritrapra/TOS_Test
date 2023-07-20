<?php

namespace App\Http\Middleware\API;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyAuthantication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator($request->all(),[
            'token' => 'required|alpha_num'
        ]);

        if ($validator->fails()) {
            $res = [
                'error' => true,
                'message' => $validator->errors()
            ];
            return response()->json($res,200);
        }


        $checkuser = User::where('access_token',$request->token)->first();
        if ($checkuser == null) {
                $res = [
                    'error' => true,
                    'message' => 'user not authrized'
                ];
                return response()->json($res,200);
        }
        if ($checkuser->token_exp < now()) {
            $res = [
                'error' => true,
                'message' => 'token expired'
            ];
            return response()->json($res,200);
        }


        $request->attributes->add(['userdata' => $checkuser]);

        return $next($request);
    }
}
