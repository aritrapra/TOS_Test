<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyWriter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $userdata = $request->get('userdata');
        if ($userdata->role != 'writer') {
            return response()->json([ 'error' => true, 'message' => 'only writer can do this action' ],200);
        }

        return $next($request);
    }
}
