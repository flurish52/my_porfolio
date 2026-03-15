<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileSettings extends Model
{

    protected $fillable = [
        'username',
        'user_id',
        'occupation',
        'picture',
        'about',
        'nav_description',
        'home_description',
        'links',
    ];

    protected $casts = [
        'links' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
