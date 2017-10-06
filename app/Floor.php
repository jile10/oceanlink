<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    public function building(){
    	return $this->belongsTo('App\Building');
    }

    public function trainingroom(){
    	return $this->hasMany('App\Trainingroom');
    }
}
