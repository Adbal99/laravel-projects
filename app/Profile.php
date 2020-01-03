<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = $this->image ?: '/profile/ygYHCGiDH70t2ta90NVv4I732sTcbmIxxB8Q6CQp.png';
        return '/storage/' . $imagePath;
    }


    public function followers()  //profile has many users that follow it 
    {
        return $this->belongsToMany(User::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
