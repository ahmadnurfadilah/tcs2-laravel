<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    // otomatis mencari sebuah table dengan nama blogs

    protected $fillable = ['user_id', 'title', 'content', 'image'];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
