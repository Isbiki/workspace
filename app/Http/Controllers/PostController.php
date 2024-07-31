<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {
    
    /**
     * Display Post members of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request){
        $searchKey = $request->input('search');
        $posts = DB::table('posts')
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->where('posts.title', 'like', '%'.$searchKey.'%')
            ->select('posts.*', 'users.name as author')
            ->orderby('posts.created_at')
            ->get();
    
        if($posts->isNotEmpty()){
            return response()->json([
                'success' => true,
                'posts' => $posts
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ]);
        }
    }
    
    public function store(Request $request){
        $validators=Validator::make($request->all(), Post::rules());
        if($validators->fails()){
            return response()->json(
                [
                    'sucess' => false,
                    'message' => 'validation failed'
                ]);
        }else{
            $post = Post::create($request->all());
            
            if($post){
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully created',
                    'post' => $post,
                ]);     
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Can not save.',
                ]);     
            }
        }
    }

    public function update(Request $request, $id)  
    {  
        $validators=Validator::make($request->all(), Post::rules());
        if($validators->fails()){
            return response()->json(
                [
                    'sucess' => false,
                    'message' => 'validation failed'
                ]);
        }  
        $post = Post::findOrFail($id);  
        $post->fill($request->all());
        if($post->save()){
            return response()->json(['success' => true, 'message' => 'Post updated successfully!', 'post' => $post]);
        }
        else{
            return response()->json(['success' => false, 'message' => 'Can not save updated Post', 'post' => $post]);
        }
    }  

    public function destroy($id) 
    {  
        try {  
            $post = Post::findOrFail($id);  
            $post->delete();  
            return response()->json(['success' => true, 'message' => 'Post deleted successfully'], 200);   
        } catch (ModelNotFoundException $e) {  
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);  
        } catch (\Exception $e) {  
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);  
        }   
    }  
    
}