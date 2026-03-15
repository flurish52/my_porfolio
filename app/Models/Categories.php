<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Categories extends Model
{

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'categories_skill', 'category_id', 'skill_id');
    }

}
