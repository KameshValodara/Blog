<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // function companyData(){
    //     return $this->belongsTo('App\Models\Company');
    // }

    function  company(){
        return $this->hasOne(Company::class);
    }

    // public function company(){
    //     return $this->hasOne(Company::class);
    // }

}
