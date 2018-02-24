<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comments;
use Auth;
use Validator;
use DB;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * commentPost the application Post Comment.
     *
     * @return \Illuminate\Http\Response
     */
	public function commentPost(Request $request){
		if ($request->input('newcomments') != '') {
			if($request->input('newcommentsid')){
				$comment = Comments::find($request->input('newcommentsid'));
				$comment->content 		= $request->input('newcomments');
				$comment->save();
				$comment = Comments::with('user')->find($comment->id);
			}else{
				$comment = new Comments;
				$comment->content 		= $request->input('newcomments');
				$comment->user_id 		= Auth::id();
				$comment->post_id 		= $request->input('id');
				$comment->save();
				$comment = Comments::with('user')->find($comment->id);
			}
			return response()->json(['status'=> 1,'message'=>'comments has been uploaded!' , 'comment' => $comment ]);
		}
		return response()->json(['status'=> 0,'message'=>'Oops, Error is coming']);
	}
}
