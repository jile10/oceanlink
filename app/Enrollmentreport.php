<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollmentreport extends Model
{
    public function trainingclass(){
    	return $this->belongsTo('App\Trainingclass');
    }

    public function assesor(){
    	return $this->hasMany('App\Assesor');
    }
}
