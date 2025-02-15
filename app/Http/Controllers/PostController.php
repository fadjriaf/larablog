<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Illuminate\Support\Str;
use Image;
use Storage;
use Session;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        //
        $posts = Post::all();

        return view('index')->withPosts($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::with('children')->whereNull('parent_id')->get();
        
        return view('post.create')->withCategories($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'category_id'   => 'required|numeric',
            'title'         => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:posts',
            'image'         => 'required|image',
            'description'   => 'required|min:3'
        ]);

        $post = new Post;

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = Str::slug($request->slug, '-');
        $post->description = $request->description;
        $post->category_id = $request->category_id;

        if ($request->hasfile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;

            Image::make($image)->save($location);

            $post->image = $filename;
        }

        Session::flash('success', 'You have successfully created a post!');
        $post->save();

        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $post = Post::where('slug', $slug)->first();

        return view('post.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //
        $post = Post::where('slug', $slug)->first();
        $categories = Category::with('children')->whereNull('parent_id')->get();

        if ($post->user_id != Auth::id()) {
            return redirect()->route('index');
        }

        return view('post.edit')->withPost($post)->withCategories($categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
        $this->validate($request, [
            'category_id'   => 'required|numeric',
            'title'         => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:posts,id,' . $slug,
            'image'         => 'sometimes|image',
            'description'   => 'required|min:3'
        ]);

        $post = Post::where('slug', $slug)->first();

        $post->title = $request->title;
        $post->slug = Str::slug($request->slug, '-');
        $post->description = $request->description;
        $post->category_id = $request->category_id;

        if ($request->hasfile('image')) {
            Storage::delete($post->image);

            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/') . $filename;

            Image::make($image)->save($location);

            $post->image = $filename;
        }

        Session::flash('success', 'You have successfully updated a post!');
        $post->save();

        return redirect()->route('post.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
        $post = Post::find($slug);
        // $post = Post::where('slug', $slug)->first();
        
        Storage::delete($post->image);
        
        Session::flash('success', 'You have successfully deleted a post!');
        $post->delete();
        
        return redirect()->route('index');
    }
}
