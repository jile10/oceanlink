<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seaexperience extends Model
{
    public function enrollee(){
    	return $this->belongsTo('App\Enrollee');
    }
}
