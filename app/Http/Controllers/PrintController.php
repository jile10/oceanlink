<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Trainingclass;
use Carbon\Carbon;
use App\Holiday;
use App\Scheduledetail;
class PrintController extends Controller
{
    public function voucher(){
    	$data = session('data');
		session()->forget('data');
		session()->forget('voucher');
        $pdf = PDF::loadView('printable/voucher',['data'=>$data])->setPaper([0,0,612,792],'portrait');
        return $pdf->stream();
    }

    public function regicard(){
    	if(count(session('enrollee'))>0)
    	{
			$data = session('enrollee');
			session()->forget('enrollee');
			//course start
			$course = array();
	    	$x=0;
	    	$holiday = Holiday::all()->where('active','=',1);
	    	foreach(session('sprog') as $sprogs){
	    		$classes = Trainingclass::find($sprogs);
	    		$check = true;
	            $checkdays = 1;
	            $dateEnd = Carbon::create();
	            $dateEnd = Carbon::parse($classes->scheduledprogram->dateStart);
	            $days = $classes->scheduledprogram->rate->duration/$classes->scheduledprogram->rate->classHour;
	            while ($check) {
	                $temp = Carbon::parse($dateEnd)->format('l');
	                $holidaycheck = false;
	                foreach($holiday as $holidays){
	                    if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)) || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateStart)->format("F d, Y") || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateEnd)->format("F d, Y")){
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
		        // //end of date end 
		        //start of schedule
		        $scounter = 0;
		        $scheck = true;
		        $schedules= "";
		        foreach ($classes->schedule->scheduledetail as $details) {
		            if($scounter != 0)
		            {
		                if($details->day->id - $scounter != 1){
		                    $scheck = false;
		                    break;
		                }
		            }
		            $scounter = $details->day->id;
		        }
		        if($scheck){
		            if($dateEnd == Carbon::parse($classes->scheduledprogram->dateStart)){
		            	$sched = Scheduledetail::where('schedule_id','=',$classes->schedule->id);
		            	$startsched = $sched->first();
			            $startsched = Carbon::parse($startsched->day->dayName)->format("D");
			            $schedules = $startsched;
			            $time = $sched->first();
			            $schedules .= ' &ensp;' . Carbon::parse($time->start)->format("g:i A") . '-' . Carbon::parse($time->end)->format("g:i A");
		            }
		            else
		            {
		            	$sched = Scheduledetail::where('schedule_id','=',$classes->schedule->id);
			            $startsched = $sched->first();
			            $startsched = Carbon::parse($startsched->day->dayName)->format("D");
			            $endsched = $sched->orderBy('id','desc')->first();
			            $endsched = Carbon::parse($endsched->day->dayName)->format("D");
			            $schedules = $startsched . '-' . $endsched;
			            $time = $sched->first();
			            $schedules .= ' &ensp;' . Carbon::parse($time->start)->format("g:i A") . '-' . Carbon::parse($time->end)->format("g:i A");
		            }
		        }
		        else
		        {
		            $schedules = array();
		            $counters = 0;
		            foreach ($classes->schedule->scheduledetail as $details) {
		                $schedules[$counters] = [
		                    'scheds' => Carbon::parse($details->day->dayName)->format("D") . ' &ensp;'. Carbon::parse($details->start)->format("g:i A") .'-'.Carbon::parse($details->end)->format("g:i A"),
		                ];
		                $counters++;
		            }
		        }
		        $course[$x] = [
		        	"id" => $x+1,
		        	"courseName" => $classes->scheduledprogram->rate->program->programName . ' ('. $classes->scheduledprogram->rate->duration .' Hours)',
		        	"dateStart" => Carbon::parse($classes->scheduledprogram->dateStart)->format('Y-m-d'),
		        	"dateEnd" => Carbon::parse($dateEnd)->format('Y-m-d'),
		        	"schedule" =>$schedules,
		        	"trainingroom"=>$classes->trainingroom->building->buildingName . ' ' . $classes->trainingroom->floor->floorName . ' Room ' . $classes->trainingroom->room_no,
		        ];
		        $x++;
	    	}
			session()->forget('sprog');
		    $pdf = PDF::loadView('printable/regicard',['data'=>$data,'course'=>$course])->setPaper([0,0,612,355],'portrait');
		    return $pdf->stream();
    	}
    	else{
    		return redirect('/collection/single');
    	}
    }

    public function certificate($id){
    	$tclass = Trainingclass::find($id);
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
    	$pdf = PDF::loadView('printable/certificate',['tclass'=>$tclass,'dateEnd'=>$dateEnd])->setPaper([0,0,612,792],'portrait');
    	return $pdf->stream();
    }
}

