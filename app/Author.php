<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors'; 
    protected $fillable = ['nombre'];

    public function books(){
        return $this->belongsToMany('App\Book','author_book','id_author','id_book');
    }
}
