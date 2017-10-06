<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accountdetail extends Model
{
    public function account(){
    	return $this->belongsTo('App\Account');
    }

    public function scheduledprogram(){
    	return $this->belongsTo('App\Scheduledprogram');
    }
}
