<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    //avliable fields
    protected $fillable = [
        'name',
        'data',
        'visible',
        'comment',
    ];


}