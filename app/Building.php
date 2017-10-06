<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public function trainingroom(){
    	return $this->hasMany('App\Trainingroom');
    }

    public function floor(){
    	return $this->hasMany('App\Floor');
    }
}
