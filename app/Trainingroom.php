<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trainingroom extends Model
{
    public function building(){
    	return $this->belongsTo('App\Building');
    }

    public function floor(){
    	return $this->belongsTo('App\Floor');
    }

    public function trainingclass(){
    	return $this->hasMany('App\Trainingclass');
    }
}
