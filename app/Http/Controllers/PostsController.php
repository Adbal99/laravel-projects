<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use \App\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');    //<----- everything below will need auth now
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id'); //only want user_id that i follow
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);  //where 'user_id' is in $users list
        //with('user') - checks the relationship with user in post model 

        return view('posts.index', compact('posts')); 
    }

     public function create()
    {
        return view('posts.create');
    }
    public function store()
    {
        $data = request()->validate([
            //'anotherField' = '',     <--- if field doesn't need a validation
            'caption'=>'required',
            'image'=>'required|image',
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1200,1200); //every image 1200x1200 px
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,                  // <---You use it when u have relationships (its about user_id)
        ]);                                                      // \App\Post::create($data);
          
        return redirect('/profile/'.auth()->user()->id);
    }
    public function show(Post $post) 
    {
         return view('posts.show', compact('post' /*'another'*/));
    }
}
