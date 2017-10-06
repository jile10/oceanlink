<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public function rate(){
    	return $this->hasOne('App\Rate');
    }
}
