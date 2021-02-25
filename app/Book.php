<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books'; 
    protected $fillable = ['nombre'];

    public function authors(){
        return $this->belongsToMany('App\Author','author_book','id_book','id_author');
    }
}
