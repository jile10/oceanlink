<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scheduledprogram;
class Rate extends Model
{
    public function program(){
    	return $this->belongsTo('App\Program');
    }

    public function unit(){
    	return $this->belongsTo('App\Unit');
    }

    public function scheduledprogram(){
    	return $this->hasMany('App\Scheduledprogram');
    }

    public function schedule(){
    	return $this->belongsTo('App\Schedule');
    }
}
