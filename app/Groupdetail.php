<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groupdetail extends Model
{
    public function groupapplication(){
    	return $this->belongsTo('App\Groupapplication');
    }

    public function groupenrollee(){
    	return $this->belongsTo('App\Groupenrollee');
    }
}
