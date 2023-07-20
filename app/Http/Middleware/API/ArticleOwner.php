<?php

namespace App\Http\Middleware\API;

use App\Models\Article;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userdata = $request->get('userdata');
        $article = $request->get('article');
        if ($article->post_by != $userdata->user_id) {
            return response()->json([ 'error' => true, 'message' => 'only owner can do this action'],200);
        }
        return $next($request);
    }
}
