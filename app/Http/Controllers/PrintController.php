<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Trainingclass;
use Carbon\Carbon;
use App\Holiday;
use App\Scheduledetail;
use App\Payment;
use App\Account;
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

    public function setEnrollmentReport(Request $request){
    	$tclass = Trainingclass::find($request->tclass_id);
    	$pdf = PDF::loadView('printable/enrollmentreport',['tclass'=>$tclass,'x'=>0])->setPaper([0,0,612,792],'portrait');
    	return $pdf->stream();
    }

    public function printCollectionReport(Request $request)
    {
    	$timePeriod ="";
    	switch($request->timePeriod)
    	{
    		case 'yearly':
    			$timePeriod = "(Year " .$request->yearly_year . ')';
					$report = Payment::whereYear('paymentDate', '=', $request->yearly_year )->get();
		    	$pdf = PDF::loadView('printable/collectionreport',["report"=>$report,"timePeriod" => $timePeriod])->setPaper([0,0,612,792],'portrait');
		    	return $pdf->stream();
    			break;
    		case 'monthly':
	    		$month = $request->monthly_month;
				$year = $request->monthly_year;
    			$timePeriod = "(" .Carbon::parse($month)->format('F'). ' '.$request->yearly_year . ')';
					$report = Payment::whereYear('paymentDate', '=', $year )
														->whereMonth('paymentDate', '=', Carbon::parse($month)->format('m'))
														->get();
		    	$pdf = PDF::loadView('printable/collectionreport',["report"=>$report,"timePeriod" => $timePeriod])->setPaper([0,0,612,792],'portrait');
		    	return $pdf->stream();
    			break;
  			case 'dateRange':
    			$dateFrom = Carbon::parse($request->dateFrom)->format("Y-m-d");
					$dateTo = Carbon::parse($request->dateTo)->format("Y-m-d");
					echo $dateFrom .' ' . $dateTo;
    			$timePeriod = "(From " .Carbon::parse($dateFrom)->format('F d,Y'). ' to '.Carbon::parse($dateTo)->format('F d,Y') . ')';
					$report = Payment::where('paymentDate', '>=' , $dateFrom)//whereBetween('paymentDate', [$dateFrom , $dateTo])
														->where('paymentDate', '<=' , $dateTo)
														->get();
		    	$pdf = PDF::loadView('printable/collectionreport',["report"=>$report,"timePeriod" => $timePeriod])->setPaper([0,0,612,792],'portrait');
		    	return $pdf->stream();
		    	break;
    	}
    }

    public function printAccountBalanceReport(Request $request)
    {
    	$timePeriod ="";
    	switch($request->timePeriod)
    	{
    		case 'yearly':
    			$timePeriod = "(Year " .$request->yearly_year . ')';
				$year = $request->yearly_year;
		        $account = Account::all();
		        $accountAll = array();
		        $totalbalance=0;
		        $x=0;
		        foreach($account as $accounts){
		            $total=0;
		            foreach ($accounts->accountdetail as $details) {
		                if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
		                {
		                    if($year == Carbon::parse($details->created_at)->format('Y')){
		                        $total += $details->balance;
		                    }
		                }
		            }
		            $name = "";
		            if(count($accounts->enrollee)>0)
		            {
		                $name = $accounts->enrollee->firstName . ' '. 
		                                            $accounts->enrollee->middleName .' '. 
		                                            $accounts->enrollee->lastName;
		            }
		            else
		                $name = $accounts->groupapplication->orgName;
		            if($total>0)
		            {
		                $accountAll[$x] = [
		                    "accountNumber" => $accounts->accountNumber,
		                    "accountName" =>$name,
		                    "balance"=>number_format($total,2),
		                ];
		                $x++;
		            	$totalbalance+=$total;
		            }
		        }
		    	$pdf = PDF::loadView('printable/accountbalance',["account"=>$accountAll,"timePeriod" => $timePeriod,"total"=>$totalbalance])->setPaper([0,0,612,792],'portrait');
		    	return $pdf->stream();
    			break;
    		case 'monthly':
	    		$month = $request->monthly_month;
		        $year = $request->monthly_year;
    			$timePeriod = "(" .Carbon::parse($month)->format('F'). ' '.$request->yearly_year . ')';
		        $account = Account::all();
		        $accountAll = array();
		        $totalbalance=0;
		        $x=0;
		        foreach($account as $accounts){
		            $total=0;
		            foreach ($accounts->accountdetail as $details) {
		                if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
		                {
		                    if($year == Carbon::parse($details->created_at)->format('Y') && $month == Carbon::parse($details->created_at)->format('F')){
		                        $total += $details->balance;
		                    }
		                }
		            }
		            $name = "";
		            if(count($accounts->enrollee)>0)
		            {
		                $name = $accounts->enrollee->firstName . ' '. 
		                                            $accounts->enrollee->middleName .' '. 
		                                            $accounts->enrollee->lastName;
		            }
		            else
		                $name = $accounts->groupapplication->orgName;
		            if($total>0)
		            {
		                $accountAll[$x] = [
		                    "accountNumber" => $accounts->accountNumber,
		                    "accountName" =>$name,
		                    "balance"=>number_format($total,2),
		                ];
		                $x++;
		            	$totalbalance+=$total;
		            }
		        }
		    	$pdf = PDF::loadView('printable/accountbalance',["account"=>$accountAll,"timePeriod" => $timePeriod,"total"=>$totalbalance])->setPaper([0,0,612,792],'portrait');
		    	return $pdf->stream();
    			break;
  			case 'dateRange':
    			$dateFrom = Carbon::parse($request->dateFrom)->format("Y-m-d");
				$dateTo = Carbon::parse($request->dateTo)->format("Y-m-d");
				echo $dateFrom .' ' . $dateTo;
    			$timePeriod = "(From " .Carbon::parse($dateFrom)->format('F d,Y'). ' to '.Carbon::parse($dateTo)->format('F d,Y') . ')';
    			$dateFrom = Carbon::parse($request->dateFrom);
				$dateTo = Carbon::parse($request->dateTo);
    			$account = Account::all();
		        $accountAll = array();
		        $x=0;
		        $totalbalance=0;
		        foreach($account as $accounts){
		            $total=0;
		            foreach ($accounts->accountdetail as $details) {
		                if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
		                {
		                    if(Carbon::parse($details->created_at)->between($dateFrom,$dateTo)){
		                        $total += $details->balance;
		                    }
		                }
		            }
		            $name = "";
		            if(count($accounts->enrollee)>0)
		            {
		                $name = $accounts->enrollee->firstName . ' '. 
		                                            $accounts->enrollee->middleName .' '. 
		                                            $accounts->enrollee->lastName;
		            }
		            else
		                $name = $accounts->groupapplication->orgName;
		            if($total>0)
		            {
		                $accountAll[$x] = [
		                    "accountNumber" => $accounts->accountNumber,
		                    "accountName" =>$name,
		                    "balance"=>number_format($total,2),
		                ];
		                $x++;
		            	$totalbalance+=$total;
		            }
		        }
		    	$pdf = PDF::loadView('printable/accountbalance',["account"=>$accountAll,"timePeriod" => $timePeriod,"total"=>$totalbalance])->setPaper([0,0,612,792],'portrait');
		    	return $pdf->stream();
    			break;
    	}
    }

    public function printNotification(Request $request){
    	$account = Account::find($request->id);
        $accountAll = array();
        $courses = array();
        $x = 0;
        $name ="";
        $address = "";
        $totalbalance=0;
        if(count($account->enrollee)>0)
        {
        	$name = $account->enrollee->firstName . ' ' . $account->enrollee->middleName . ' ' . $account->enrollee->lastName;
        	$address = $account->enrollee->street . ' ' . $account->enrollee->barangay . ' ' . $account->enrollee->city;
        }
        else
        {
        	$name = $account->groupapplication->orgName;
        	$address = $account->groupapplication->orgAddress;
        }

        foreach($account->accountdetail as $details)
        {
        	$total = 0;
        	if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
            {	
                $total = $details->balance;
                if($total > 0)
                {
                	$totalbalance += $total;
	                $courses[$x] = [
	                	"course_name"=> $details->scheduledprogram->rate->program->programName .' ('.$details->scheduledprogram->rate->duration.' Hours)',
	                	"balance"=>$total,
	                ];
	                $x++;
                }
            }	
        }
        $accountAll[0]= [
        	"name"=>$name,
        	"address"=>$address,
        	"courses"=>$courses,
        ];
    	$pdf = PDF::loadView('printable/notification',["account"=>$accountAll,"total"=>$totalbalance])->setPaper([0,0,612,792],'portrait');
    	return $pdf->stream();
    }
}

