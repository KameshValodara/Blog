<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps =false;

    //Polymorphic Relationship
    //morphOne
    public function image(){
        return $this->morphOne(Image::class,'imagable');
    }
    //morphMany
    public function manyImage(){
        return $this->morphMany(Image::class,'imagable');
    }
    //morphToMany
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable');
    }



}
