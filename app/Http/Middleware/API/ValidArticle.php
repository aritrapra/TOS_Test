<?php

namespace App\Http\Middleware\API;

use Closure;
use App\Models\Article;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidArticle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $validator = Validator($request->all(),[
            'id' => 'required|alpha_num'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'error' => true, 'message' => $validator->errors()],200);
        }

        //check the article
        $id = $request->id;

        $article = Article::where('id',$id)->where('delete',0)->first();
        if ($article == null) {
            return response()->json([ 'error' => true, 'message' => 'article with that id not exists'],200);
        }

        $request->attributes->add(['article' => $article]);
        return $next($request);
    }
}
