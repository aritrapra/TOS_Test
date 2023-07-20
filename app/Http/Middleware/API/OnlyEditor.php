<?php

namespace App\Http\Middleware\API;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $userdata = $request->get('userdata');
        if ($userdata->role != 'editor') {
            return response()->json([ 'error' => true, 'message' => 'only editor can do this action' ],200);
        }
        return $next($request);
    }
}
