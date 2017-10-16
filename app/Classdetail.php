<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classdetail extends Model
{
    public function trainingclass(){
    	return $this->belongsTo('App\Trainingclass');
    }

    public function enrollee(){
    	return $this->belongsTo('App\Enrollee');
    }

    public function grade(){
    	return $this->hasOne('App\Grade');
    }

    public function certificate(){
    	return $this->belongsTo('App\Certificate');
    }

    public function attend(){
        return $this->hasMany('App\Attend');
    }
}
