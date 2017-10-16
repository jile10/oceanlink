<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function attend(){
    	return $this->hasMany('App\Attend');
    }
}
