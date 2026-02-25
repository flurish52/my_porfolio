<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMe extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'contact_user_name',
'contact_user_email',
'contact_user_message',
    ];
}
