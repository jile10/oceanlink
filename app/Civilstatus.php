<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Civilstatus extends Model
{
    public function enrollee(){
    	return $this->hasMany('App\Enrollee');
   	}
}
