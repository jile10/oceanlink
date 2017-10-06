<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupapplication extends Model
{
    public function trainingclass(){
    	return $this->belongsTo('App\Trainingclass');
    }

    public function groupschedule(){
    	return $this->belongsTo('App\Groupschedule');
    }

    public function groupdetail(){
    	return $this->hasMany('App\Groupdetail');
    }

    public function account(){
    	return $this->belongsTo('App\Account');
    }

    public function groupapplicationdetail(){
        return $this->hasMany('App\Groupapplicationdetail');
    }
}
