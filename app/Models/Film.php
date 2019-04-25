<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    public function getDirector(){
        return $this->belongsTo(Director::class,'director_id','id')->first();
    }
}
