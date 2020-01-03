<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


class ProfilesController extends Controller
{
    public function index(User $user)
    {   
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;
        //^ if (user is auth) ?(then) do this^ :(otherwise) return false

        $postCount = Cache::remember(
            'count.posts.' . $user->id, 
        now()->addSeconds(30),              //addDay,addMonths, etc..
        function() use ($user)
         {
           return $user->posts->count();
        });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id, 
        now()->addSeconds(30),              
        function() use ($user)
         {
           return $user->profile->followers->count();
        });
        
        $followingCount = Cache::remember(
            'count.following.' . $user->id, 
        now()->addSeconds(30), 
        function() use ($user)
         {
           return $user->following->count();
        });

        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'url',
            'image'=>'', 
        ]);

       // dd($data);
       
       if(request('image'))
       {
           
           $imagePath = request('image')->store('profile', 'public');
           
           $image = Image::make(public_path("/storage/{$imagePath}"))->fit(1000,1000); //every image 1000x1000 
           $image->save();
           $imageArray = ['image' =>$imagePath];
           
        }


        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []         //<-this overwrites the image array in the array
        ));                           // ?? = if imageArray is not set, put empty array []
        return redirect("/profile/{$user->id}");

    }
}