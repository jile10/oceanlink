<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Account;
use App\Rate;
use App\Accountdetail;
use App\Trainingclass;
use App\Nosessionday;
use App\Holiday;
use Carbon\Carbon;
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

    public function getCancel(Request $request){
        $trainingclass = Trainingclass::where('status','=',5)->orderBy('updated_at')->get();
        $courseArray = array();
        $x=0;
        foreach($trainingclass as $tclasses){
            $counter = 0;
            $courseArray[$x] = [
                "program_type" =>$tclasses->scheduledprogram->rate->program->programtype->typeName,
                "course_name" =>$tclasses->scheduledprogram->rate->program->programName . ' ('. $tclasses->scheduledprogram->rate->duration. ' Hours)',
                "date"=>Carbon::parse($tclasses->updated_at)->format('F d,Y')
            ];
            $x++;
        }
        return response()->json($courseArray);
    }

    public function getOngingTrainingclass(Request $request){
        $trainingclass = Trainingclass::where('status','=',2)->orderBy('updated_at')->get();
        $courseArray = array();
        $x=0;
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
        foreach($trainingclass as $tclasses){
                $check = true;
                $checkdays = 1;
                $dateEnd = Carbon::create();
                $dateEnd = Carbon::parse($tclasses->scheduledprogram->dateStart);
                $days = $tclasses->scheduledprogram->rate->duration/$tclasses->scheduledprogram->rate->classHour;
                while ($check) {
                    $temp = Carbon::parse($dateEnd)->format('l');
                    $holidaycheck = false;
                    foreach($holiday as $holidays){
                        if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
                            $holidaycheck = true;
                        }
                    }
                    foreach($sessionday as $sessiondays){
                        if(Carbon::parse($dateEnd)->between(Carbon::parse($sessiondays->dateStart), Carbon::parse($sessiondays->dateEnd))){
                            $holidaycheck = true;
                        }
                    }

                    if($holidaycheck == false)
                    {
                        foreach ($classes->schedule->scheduledetail as $details) {
                            if($temp == $details->day->dayName){
                                $checkdays++;
                            }
                        }
                    }
                    if($checkdays == $days)
                    {
                        $check = false;
                    }
                    else{

                        $dateEnd = Carbon::parse($dateEnd)->addDays(1);
                    }
                }
            $courseArray[$x] = [
                "program_type" =>$tclasses->class_name,
                "course_name" =>$tclasses->scheduledprogram->rate->program->programName . ' ('. $tclasses->scheduledprogram->rate->duration. ' Hours)',
                "dateStart"=>Carbon::parse($tclasses->updated_at)->format('F d,Y'),
                "dateEnd" => Carbon::parse($dateEnd)->format('F d,Y')
            ];
            $x++;
        }
        return response()->json($courseArray);
    }
}
