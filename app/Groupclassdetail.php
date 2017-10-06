<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupclassdetail extends Model
{
    public function groupenrollee(){
    	return $this->belongsTo('App\Groupenrollee');
    }

    public function certificate(){
    	return $this->belongsTo('App\Certificate');
    }

    public function groupgrade(){
    	return $this->hasOne('App\Groupgrade');
    }

    public function trainingclass(){
    	return $this->belongsTo('App\Trainingclass');
    }
}
