<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function create(Request $request){

        $validator = Validator($request->all(),[
            'title' => 'required|min:4|max:100|string',
            'post' => 'required|min:4|max:4000|string',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'error' => true, 'message' => $validator->errors() ],200);
        }

        //creating new article
        $userdata = $request->get('userdata');

        $article = new Article;
        $article->post_by = $userdata->user_id;
        $article->title = $request->title;
        $article->post = $request->post;
        $id = UniqueHash($article);
        $article->id = $id;
        $article->save();

        return response()->json([ 'error' => false, 'id' => $id, 'message' => 'article posted' ],200);

    }



    public function get(Request $request){
        $article =  $request->get('article');
        $res = [
            'error' => true,
            'data' => [
                'title' => $article->title,
                'post' => $article->post
            ]
        ];
        return response()->json($res,200);
    }

    public function update(Request $request){
        $validator = Validator($request->all(),[
            'title' => 'min:4|max:100',
            'post' => 'min:4|max:4000',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'error' => true, 'message' => $validator->errors() ],200);
        }

        $userdata = $request->get('user');
        $article = $request->get('article');
        $title = $article->title;
        $post = $article->post;
        if (isset($request->title)) {
            $title = $request->title;
        }
        if (isset($request->post)) {
            $post = $request->post;
        }

        Article::where('id',$request->id)->update([
            'title' => $title,
            'post' => $post
        ]);

        return response()->json([ 'error' => false, 'message' => 'post updated' ],200);

    }


    public function delete(Request $request){
        Article::where('id',$request->id)->update([
            'delete' => 1
        ]);
        return response()->json([ 'error' => false, 'message' => 'post deleted' ],200);
    }


    public function comments(Request $request){
        $comments = Comment::where('article_id',$request->id)->paginate(20);
        return response()->json([ 'error' => false, 'data' => $comments ],200);
    }


    public function all(Request $request){
        $articles = Article::where('delete',0)->paginate(20);
        return response()->json([ 'error' => false, 'data' => $articles ],200);
    }


}
