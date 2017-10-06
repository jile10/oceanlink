<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function scheduledetail(){
    	return $this->hasMany('App\Scheduledetail');
    }

    public function program(){
    	return $this->belongsTo('App\Program');
    }

    public function rate(){
    	return $this->hasOne('App\Rate');
    }
}
