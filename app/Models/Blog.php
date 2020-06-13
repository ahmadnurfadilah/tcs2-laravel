<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // otomatis mencari sebuah table dengan nama blogs

    protected $fillable = ['user_id', 'title', 'content', 'image'];
}

