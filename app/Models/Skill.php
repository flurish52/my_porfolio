<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    protected $fillable = ['name'];

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'categories_skill', 'skill_id', 'category_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }
}
