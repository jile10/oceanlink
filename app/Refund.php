<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    //
	public function enrollee(){
		return $this->belongsTo('App\Enrollee');
	}

	public function trainingclass(){
		return $this->belongsTo('App\Trainingclass');
	}
}
