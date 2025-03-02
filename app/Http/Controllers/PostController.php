<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostsExport;
class PostController extends Controller
{
    //
    public function index(Request $request)
    {
        $posts=Post::all();
        if($request->has('export')&& $request->export=='excel')
        {
            return Excel::download(new PostsExport($posts), 'posts.xlsx');
        }
        return response()->json($posts);
    }
    public function show($id)
    {
        $post=Post::find($id);
        if(!$post)
        {
            return response()->json(['message'=>'post not found'],404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Post found successfully',
            'data' => $post
        ], 200);
    }
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string',
            'image' => 'required|string',
            ]);
    
    $post=Post::create($validated);
    return response()->json($post);
    }
    public function update(Request $request,$id)
    {
        $post=Post::find($id);
        if(!$post)
        {
            return response()->json(['message'=>'post not found'],404);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string',
            'image' => 'required|string',
            ]);
    
    $post->update($validated);
    return response()->json($post);
    }

  public function destroy($id)
    {
        $post=Post::find($id);
        if(!$post)
        {
            return response()->json(['message'=>'post not found'],404);
        }
      
    $post->delete();
    return response()->json(['message'=>'post deleted sucessfully']);
    }
    public function export_web()
    {
        $posts=Post::all();
        
            return Excel::download(new PostsExport($posts), 'posts.xlsx');
       
    }
}
