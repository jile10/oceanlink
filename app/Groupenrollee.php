<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupenrollee extends Model
{
    public function civilstatus(){
    	return $this->belongsTo('App\Civilstatus');
    }

    public function groupclassdetail(){
    	return $this->hasMany('App\Groupclassdetail');
    }
    
    public function educationalbackground(){
        return $this->belongsTo('App\Educationalbackground');
    }

    public function contactperson(){
        return $this->belongsTo('App\Contactperson');
    }
}
