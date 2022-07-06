<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function companyDetails(){
        //return $this->belongsTo(Member::class);
        return $this->hasOne(CompanyDetail::class);
    }

    //Many To Many Relationships
    public function members(){
        return $this->belongsToMany(Member::class,'member_companies');
    }
}
