<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupapplicationdetail extends Model
{
    public function groupapplication(){
    	return $this->belongsTo('App\Groupapplication');
    }

    public function trainingclass(){
    	return $this->belongsTo('App\Trainingclass');
    }
}
