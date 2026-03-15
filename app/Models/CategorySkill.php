<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySkill extends Model
{
    protected $table = 'categories_skill';

    // If you want mass assignment
    protected $fillable = ['category_id', 'skill_id'];
}
