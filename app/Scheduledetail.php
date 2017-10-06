<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scheduledetail extends Model
{
	public function schedule(){
		return $this->belongsTo('App\Schedule');
	}

	public function day(){
		return $this->belongsTo('App\Day');
	}
}
