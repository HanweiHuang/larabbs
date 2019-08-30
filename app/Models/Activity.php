<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'subject_id',
        'subject_type',
        'name',
        'user_id'
    ];
}
