<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupscheduledetail extends Model
{
    public function groupschedule(){
    	return $this->belongsTo('App\Groupschedule');
    }

    public function day(){
    	return $this->belongsTo('App\Day');
    }
}
