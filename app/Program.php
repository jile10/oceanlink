<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function programtype(){
    	return $this->belongsTo('App\Programtype');
    }

    public function schedule(){
    	return $this->hasOne('App\Schedule');
    }

    public function rate(){
    	return $this->hasMany('App\Rate');
    }
}
