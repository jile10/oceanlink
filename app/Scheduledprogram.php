<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rate;
class Scheduledprogram extends Model
{
   	public function rate(){
   		return $this->belongsTo('App\Rate');
   	}

   	public function trainingofficer(){
   		return $this->belongsTo('App\Trainingofficer');
   	}

   	public function trainingclass(){
   		return $this->hasOne('App\Trainingclass','scheduledprogram_id','id');
   	}
   	
      public function accountdetail(){
         return $this->hasOne('App\Accountdetail');
      }
}
