<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assesor extends Model
{
    public function enrollmentreport(){
    	return $this->belongsTo('App\Enrollmentreport');
    }
}
