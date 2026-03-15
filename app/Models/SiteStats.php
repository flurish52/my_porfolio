<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteStats extends Model
{
    //

    protected $fillable = [
        'value',
        'suffix',
        'label',
    ];
}
