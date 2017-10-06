<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public function detail(){
    	return $this->hasMany('App\Scheduledetail');
    }
}
