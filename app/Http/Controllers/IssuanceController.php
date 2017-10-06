<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trainingclass;
use Carbon\Carbon;
use App\Holiday;
use App\Attend;
use App\Groupattend;
use App\Scheduledetail;
use App\Classdetail;
use App\Nosessionday;
use PDF;
class IssuanceController extends Controller
{
    public function viewClass(){
        $tclass = Trainingclass::all()->where('status','=',3);
        return view("admin/Issuance_Certificate/class",compact('tclass'));
    }

    public function viewDetailClass(Request $request){
    	$tclass= Trainingclass::find($request->id);
    	return view('admin/Issuance_Certificate/detail',compact('tclass'));
    }

    public function certificate(Request $request){
    	$classdetail = array();
    	for($i=0;$i<count($request->classdetail_id);$i++){
    		$detail = Classdetail::find($request->classdetail_id[$i]);
    		$classdetail[$i] = [
    			"Name" => $detail->enrollee->firstName . ' ' . strtoupper($detail->enrollee->middleName[0]).'. ' . $detail->enrollee->lastName,
    			"dob"=> Carbon::parse($detail->enrollee->dob)->format('F d, Y'),
    			"certificate_no" => $detail->certificate->certificate_no,
    			"day" => Carbon::parse($detail->certificate->date_issued)->format('d'),
    			"month" =>Carbon::parse($detail->certificate->date_issued)->format('F'),
    			"year" =>Carbon::parse($detail->certificate->date_issued)->format('Y'),
    		];
    	}
		$tclass = Trainingclass::find($request->trainingclass_id);
    	$holiday = Holiday::all()->where('active','=',1);
    	// start of date end
            $check = true;
            $checkdays = 1;
            $dateEnd = Carbon::create();
            $dateEnd = Carbon::parse($tclass->scheduledprogram->dateStart);
            $days = $tclass->scheduledprogram->rate->duration/$tclass->scheduledprogram->rate->classHour;
            while ($check) {
                $temp = Carbon::parse($dateEnd)->format('l');
                $holidaycheck = false;
                foreach($holiday as $holidays){
                    if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)) || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateStart)->format("F d, Y") || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateEnd)->format("F d, Y")){
                        $holidaycheck = true;
                    }
                }
                $check = Nosessionday::where('date',Carbon::parse($dateEnd)->format('Y-m-d'))->get();
                if(count($check)>0)
                {
                    $holidaycheck = true;
                }
                if($holidaycheck == false)
                {
                    foreach ($tclass->schedule->scheduledetail as $details) {
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
        	//end of date end
    	$pdf = PDF::loadView('admin/Issuance_Certificate/certificate',['tclass'=>$tclass,'dateEnd'=>$dateEnd,'detail'=>$classdetail])->setPaper([0,0,612,792],'portrait');
    	return $pdf->stream();
    }
}
