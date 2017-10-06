<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Account;
use App\Rate;
use App\Accountdetail;
class QueriesController extends Controller
{
    public function viewQueries(){
    	return view('admin/queries/queries');
    }

    public function getBalance(Request $request){
		$nicole = Accountdetail::all();
    	$nicolearray = array();
    	$x=0;
    	foreach($nicole as $nicoles){
            if($nicoles->scheduledprogram->trainingclass->status != 1 && $nicoles->scheduledprogram->trainingclass->status != 0)
            {
                if($nicoles->balance>0)
                {
            		$nicolearray[$x] = [
            			"accountNumber" =>$nicoles->account->accountNumber,
            			"accountName" =>$nicoles->account->enrollee->firstName . ' ' . $nicoles->account->enrollee->middleName . ' ' . $nicoles->account->enrollee->lastName,
            			"balance" =>number_format($nicoles->balance,2),
            		];
            		$x++;   
                }
            }       
    	}
    	return response()->json($nicolearray);
    }
    public function getCourse(Request $request){
        $rate = Rate::all();
        $courseArray = array();
        $x=0;
        foreach($rate as $rates){
            $counter = 0;
            foreach($rates->scheduledprogram as $sprogs){
                    $counter += count($sprogs->trainingclass->classdetail->where('status','!=',1));
            }
            $courseArray[$x] = [
                "program_type" =>$rates->program->programtype->typeName,
                "course_name" =>$rates->program->programName . ' ('. $rates->duration. ' Hours)',
                "counter" =>$counter,
            ];
            $x++;
        }
         return response()->json($courseArray);
    }
}
