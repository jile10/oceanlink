<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupschedule extends Model
{
    public function groupapplication(){
    	return $this->hasOne('App\Groupapplication');
    }

    public function groupscheduledetail(){
    	return $this->hasMany('App\Groupscheduledetail');
    }
}
