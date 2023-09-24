<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//to manage data

class Article extends Model
{
    use HasFactory;
// one article to one category
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
//one article with many comments
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
