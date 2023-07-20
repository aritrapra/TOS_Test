<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request){

        $validator = Validator($request->all(),[
            'comment' => 'required|min:4|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json([ 'error' => true, 'message' => $validator->errors() ],200);
        }

        $userdata = $request->get('userdata');

        $comment = new Comment;
        $comment->post_by = $userdata->user_id;
        $comment->article_id = $request->id;
        $comment->comment = $request->comment;
        $comment->id = UniqueHash($comment);
        $comment->save();
        return response()->json([ 'error' => false, 'message' => 'comment sucessfully posted' ],200);
    }
}
