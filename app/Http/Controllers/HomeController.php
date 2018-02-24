<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Category;
use App\Models\Comments;
use Auth;
use Validator;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
		$post_category = DB::table('categories')->pluck('name', 'id');
		return view('posthome')->with('post_category', $post_category);
    }
	
	/**
    * Add POST will add new post.
    *
    * @return \Illuminate\Http\Response
    */
	 
	public function addpost(Request $request){
		
		$validator  = $validator = Validator::make($request->all() , [
            'title' 		=> 'required',
			'content' 		=> 'required',
        ]);
		if ($validator->passes()) {
			if($request->input('category_id') == 0){
				$cat 			= new Category;
				$cat->name 		= $request->input('newcat');
				$cat->user_id 	= Auth::id();
				$cat->save();
			}
			
			$post = new Posts;
			$post->title 		= $request->input('title');
			$post->content 		= $request->input('content');
			$post->category_id 	= $request->input('category_id') == 0 ?  $cat->id : $request->input('category_id') ;
			$post->user_id 		= Auth::id();
			$post->save();
			$post = Posts::with(['category' , 'comments.user' , 'user'])->find($post->id);
			return response()->json(['status'=> 1,'message'=>'post has been uploaded!' , 'post' => $post ]);
		}
		return response()->json(['status'=> 0,'message'=>$validator->errors()->all()]);
	}
	
	/**
    * Owner of post can update post.
    *
    * @return \Illuminate\Http\Response
    */
	public function updatepost(Request $request){
		if(Auth::id() == $request->input('user_id')){
			$validator  = $validator = Validator::make($request->all() , [
				'title' 		=> 'required',
				'content' 		=> 'required',
			]);
			if ($validator->passes()) {
				if($request->input('category_id') == 0){
					$cat 			= new Category;
					$cat->name 		= $request->input('newcat');
					$cat->user_id 	= Auth::id();
					$cat->save();
				}
				
				$post = Posts::find($request->input('id'));
				$post->title 		= $request->input('title');
				$post->content 		= $request->input('content');
				$post->category_id 	= $request->input('category_id') == 0 ?  $cat->id : $request->input('category_id') ;
				$post->user_id 		= Auth::id();
				$post->save();
				$post = Posts::with(['category' , 'comments.user' , 'user'])->find($post->id);
				return response()->json(['status'=> 1,'message'=>'post has been uploaded!' , 'post' => $post ]);
			}
		return response()->json(['status'=> 0,'message'=>$validator->errors()->all()]);
		}
	}
	
	/**
    * Get Posts pagenation in ajax.
    *
    * @return \Illuminate\Http\Response
    */
	
	public function getPosts(Request $request)  { 
		if($request->query('cat')){
			$cat = $request->query('cat');
		}else{
			$cat ='';
		}
		
		if($request->query('querytext')){
			$querytext = $request->query('querytext');
		}else{
			$querytext ='';
		}
		
		
		return response()->json(Posts::with(['category'  ,  'comments.user' , 'user'])
		->withCount('comments')	
		->where(function($query) use ($cat , $querytext)  {
            if($cat != '') {
				$query->where('category_id', $cat);
            }
			
			if($querytext != '') {
				$query->orWhere('title','like' , "%$querytext%");
				$query->orWhere('content','like' , "%$querytext%");
            }
			
		})->paginate(10)); 
	} 
	
	/**
    * Get single post.
    *
    * @return \Illuminate\Http\Response
    */
	
	public function singlePosts($id){
		return response()->json(Posts::with(['category'  , 'comments' , 'comments.user' , 'user'])
		->withCount('comments')	
		->where('id',$id)->get()); 
	} 
	
	/**
    * Check user and send fist posts.
    *
    * @return \Illuminate\Http\Response
    */
	
	public function checkuserandgetPost()  {
		$posts = Posts::with(['category' , 'comments.user' , 'user'])->withCount('comments')->paginate(10);
		
		if (Auth::user()){
			return response()->json(['user' => Auth::user() , 'post_category' => DB::table('categories')->pluck('name', 'id') ,  'posts' => $posts]);
		}else{
			return response()->json(['user' => '' ,  'post_category' => DB::table('categories')->pluck('name', 'id') ,  'posts' => $posts]);
		}
	}
}
