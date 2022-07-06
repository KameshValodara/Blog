<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    public $timestamps = false;
    // function companyData(){
    //     return $this->belongsTo('App\Models\Company');
    // }

    //Laravel Accessor
    public function getNameAttribute($value){
        return ucfirst($value);
    }
    public function getAddressAttribute($value){
        return $value.', India.';
    }
    //

    //Laravel Mutator
    public function setNameAttribute($value){
        return $this->attributes['name']="Mr ".$value;
    }
    public function setAddressAttribute($value){
        return $this->attributes['address']=$value.' ,India.';
    }
    //
    function  company(){
        return $this->hasMany(Company::class);
    }
    function  member(){
        return $this->hasMany(Member::class);
    }
    function member_details(){
        return $this->hasOne(MemberDetail::class);
    }

    //Many To Many Relationships
    function companies(){
        return $this->belongsToMany(Company::class,'member_companies');
    }

    //HasOneThrough
    function member_Tocompany_details(){
        return $this->hasManyThrough(CompanyDetail::class,Company::class);
    }

    //hasOneOfMany
    function latest_ofMany(){
        return $this->hasOne(Company::class)->latestOfMany();
    }
    function oldest_ofMany(){
        return $this->hasOne(Company::class)->oldestOfMany();
    }
    function ofMany(){
        return $this->hasOne(Company::class)->ofMany('name', 'min');
    }

    //Polymorphic Relationship
    public function image(){
        return $this->morphOne(Image::class,'imagable');
    }

    public function manyImage(){
        return $this->morphMany(Image::class,'imagable');
    }

}
