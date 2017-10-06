<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function groupapplication(){
    	return $this->hasOne('App\Groupapplication');
    }

    public function enrollee(){
    	return $this->hasOne('App\Enrollee');
    }
    public function payment(){
    	return $this->hasMany('App\Payment');
    }

    public function accountdetail(){
    	return $this->hasMany('App\Accountdetail');
    }
}
