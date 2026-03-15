<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use softDeletes;

    protected $fillable = [
        'title',
        'description',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }


}
