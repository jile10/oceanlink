<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollee extends Model
{
    public function civilstatus(){
    	return $this->belongsTo('App\Civilstatus');
    }

    public function classdetail(){
    	return $this->hasMany('App\Classdetail');
    }

    public function account(){
    	return $this->belongsTo('App\Account');
    }

    public function contactperson(){
        return $this->belongsTo('App\Contactperson');
    }

    public function seaexperience(){
        return $this->hasOne('App\Seaexperience','enrollee_id',"id");
    }

    public function educationalbackground(){
        return $this->belongsTo('App\Educationalbackground');
    }

    public function trainingattend(){
        return $this->hasMany('App\Trainingattend');
    }
}
