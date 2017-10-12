<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Define Access control
    public function __construct()
    {
        //except some page
        //$this->middleware('auth');
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {

        //$posts = Post::all();
        //$post = Post::where('title', 'Post Two')-get();
        //$posts = DB::select('SELECT * FROM posts');

        //$posts = Post::orderBy('title', 'desc')->take(2)->get();
        //$posts = Post::orderBy('title', 'asc')->get();

        $posts = Post::orderBy('title', 'desc')->paginate(5);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        //Handle File Upload
        if($request->hasFile('cover_image')){
            //Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just ext.
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Upload Image this will store in storage->app->public it unaccessible through the browser
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{
            //Default Image
            $fileNameToStore = 'noimage.jpg';
        }

        //return '123';
        //Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        //access db
        $post->user_id = auth()->user()->id;

        $post->cover_image = $fileNameToStore;
        $post->save();

        $posts = Post::orderBy('title', 'desc')->paginate(5);
        //return view('posts.index')->with('posts', $posts);
        return redirect('/post')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        //Check for correct user to edit the post
        if(auth()->user()->id !== $post->user_id){
            return redirect('/post')->with('Error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required'
        ]);
        //return '123';
        //Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        $posts = Post::orderBy('title', 'desc')->paginate(5);
        //return view('posts.index')->with('posts', $posts);
        return redirect('/post')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
            //Check for correct user to edit the post
            if(auth()->user()->id !== $post->user_id){
                return redirect('/post')->with('Error', 'Unauthorized Page');
            }
        $post->delete();
        return redirect('/post')->with('success', 'Post Removed');
    }
}
