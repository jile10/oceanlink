<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scheduledprogram;
use App\Civilstatus;
use App\Educationalbackground;
use App\Seaexperience;
use App\Contactperson;
use App\Trainingattend;
use App\Enrollee;
use Carbon\Carbon;
use App\Classdetail;
use App\Trainingclass;
use App\Program;
use App\Programtype;
use App\Day;
use App\Schedule;
use App\Scheduledetail;
use App\Holiday;
use App\Account;
use App\Accountdetail;
use App\Rate;
use App\Nosessionday;
class HomeController extends Controller
{
	public function home(){
		$sprogram = Scheduledprogram::all()->where('active','=',1);
		return view('/home/welcome',compact('sprogram'));

		//update all status
		$tclass = Trainingclass::all()->where('status',1);
		Carbon::now('Asia/Singapore');
		/*
		foreach ($tclass as $tclass ) {
			if(Carbon::parse($tclass->scheduledprogram->dateStart)->lt(Carbon::now('Asia/Singapore'))){
				$class = Trainingclass::find($tclass->id);
				$class->status = 2;
				$class->save();
			}
		}
		*/
	}

	public function courses(){
		$sprogram = Scheduledprogram::all()->where('active','=',1);
		return view('/home/courses',compact('sprogram'));
	}

	public function facilities(){
		return view ('/home/facilities');
	}
	
	public function programs(){
		$program = Program::all()->where("active","=",1);
		$type = Programtype::all()->where("active","=",1);
		return view ('/home/program',compact('program','type'));
	}

	public function courseRegister(Request $request){
        $scheduledprogram = Scheduledprogram::all()->where('active','=',1);
        $class = array();
        $day = Day::all();
        $x=0;
        $y=0;
        $class = Trainingclass::all()->where('status','=',1);
        $tclass=array();
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
        foreach ($class as $classes) {
            // start of date end
            if(count($classes->groupapplicationdetail)==0)
            {
                $check = true;
                $checkdays = 0;
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
                    else
                    {
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
                    $sched = Scheduledetail::where('schedule_id','=',$classes->schedule->id);
                    $startsched = $sched->first();
                    $startsched = Carbon::parse($startsched->day->dayName)->format("D");
                    $endsched = $sched->orderBy('id','desc')->first();
                    $endsched = Carbon::parse($endsched->day->dayName)->format("D");
                    $schedules = $startsched . '-' . $endsched;
                    $time = $sched->first();
                    $schedules .= ' &ensp;' . Carbon::parse($time->start)->format("g:i A") . '-' . Carbon::parse($time->end)->format("g:i A");

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
                //end of schedule
                $tclass[$x] = [
                    'id' =>$classes->id,
                    'class_name' =>$classes->class_name,
                    'course_name' => $classes->scheduledprogram->rate->program->programName . ' (' . $classes->scheduledprogram->rate->duration . ' Hours) ',
                    'dateStart' =>Carbon::parse($classes->scheduledprogram->dateStart)->format("F d, Y"),
                    'dateEnd' => Carbon::parse($dateEnd)->format("F d, Y"),
                    'officer' => $classes->scheduledprogram->trainingofficer->firstName . ' ' . $classes->scheduledprogram->trainingofficer->middleName . ' ' . $classes->scheduledprogram->trainingofficer->lastName,
                    'sched' => $schedules,
    				'fee' => $classes->scheduledprogram->rate->price,
    				'type' => $classes->scheduledprogram->rate->program->programtype->typeName,
    				'sdetail' => $classes->schedule->scheduledetail,
                ];
                $x++;
            }
        }
		$cstatus = Civilstatus::all();
		return view('/home/registercourse',compact('tclass','cstatus','class'));
	}

	public function next(Request $request){
		$request->session()->flash('sprogram_id',$request->id);
		return redirect('/iEnroll');
	}
	public function iApply(Request $request){
       if(session()->has('sprogram_id'))
       {
        $enrollee = Enrollee::all();
        $scheduledprogram = Scheduledprogram::all()->where('active','=',1);
        $class = array();
        $day = Day::all();
        $x=0;
        $y=0;
        $class = Trainingclass::all()->where('status','=',1);
        $tclass=array();
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
        foreach ($class as $classes) {
            // start of date end
            $check = true;
            $checkdays = 1;
            $dateEnd = Carbon::create();
            $dateEnd = Carbon::parse($classes->scheduledprogram->dateStart);
            $days = $classes->scheduledprogram->rate->duration/$classes->scheduledprogram->rate->classHour;
            while ($check) {
                $dateEnd = Carbon::parse($dateEnd)->addDays(1);
                $temp = Carbon::parse($dateEnd)->format('l');
                $holidaycheck = false;
                foreach($holiday as $holidays){
                    if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)) || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateStart)->format("F d, Y") || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateEnd)->format("F d, Y")){
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

                    if($checkdays == $days)
                    {
                        $check = false;
                    }
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
                $sched = Scheduledetail::where('schedule_id','=',$classes->schedule->id);
                $startsched = $sched->first();
                $startsched = Carbon::parse($startsched->day->dayName)->format("D");
                $endsched = $sched->orderBy('id','desc')->first();
                $endsched = Carbon::parse($endsched->day->dayName)->format("D");
                $schedules = $startsched . '-' . $endsched;
                $time = $sched->first();
                $schedules .= ' &ensp;' . Carbon::parse($time->start)->format("g:i A") . '-' . Carbon::parse($time->end)->format("g:i A");

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
            //end of schedule
            $tclass[$x] = [
                'id' =>$classes->id,
                'class_name' =>$classes->class_name,
                'course_name' => $classes->scheduledprogram->rate->program->programName . ' (' . $classes->scheduledprogram->rate->duration . ' Hours) ',
                'dateStart' =>Carbon::parse($classes->scheduledprogram->dateStart)->format("F d, Y"),
                'dateEnd' => Carbon::parse($dateEnd)->format("F d, Y"),
                'officer' => $classes->scheduledprogram->trainingofficer->firstName . ' ' . $classes->scheduledprogram->trainingofficer->middleName . ' ' . $classes->scheduledprogram->trainingofficer->lastName,
                'sched' => $schedules,
				'fee' => $classes->scheduledprogram->rate->price,
				'type' => $classes->scheduledprogram->rate->program->programtype->typeName,
				'sdetail' => $classes->schedule->scheduledetail,
            ];
            $x++;
        }
        $cstatus = Civilstatus::all();
				return view('/home/apply',compact('tclass','cstatus','class','enrollee'));
       }
       else{
        session()->flash('message','Please select a course first');
        return redirect('/registercourse');
       }
	}

    public function getEnrollee(Request $request){
        $data = Enrollee::where('studentNumber',$request->studentNumber)->first();
        $alldata = array();
        if(count($data)>0){
            $seaexp = Seaexperience::where('enrollee_id',$data->id)->get();
            $tattends = Trainingattend::where('enrollee_id',$data->id)->get();
            $alldata[0] = [
                "enrollee_id" =>$data->id,
                "firstName" =>$data->firstName,
                "middleName" =>$data->middleName,
                "lastName" =>$data->lastName,
                "cstatus_id" =>$data->civilstatus->id,
                "gender" =>$data->gender,
                "dob" =>$data->dob,
                "dop" =>$data->birthPlace,
                "street" =>$data->street,
                "barangay" =>$data->barangay,
                "city" =>$data->city,
                "contact" =>$data->contact,
                "email" =>$data->email,
                "attainment" =>$data->educationalbackground->attainment,
                "school" =>$data->educationalbackground->school,
                "course" =>$data->educationalbackground->course,
                "cname" =>$data->contactperson->name,
                "crelationship" =>$data->contactperson->relationship,
                "caddress" =>$data->contactperson->address,
                "ccontact" =>$data->contactperson->contact,
                "seaxp" =>$seaexp,
                "tattend" =>$tattends,
            ];
        }
        return response()->json($alldata);
    }

	public function insertiApply(Request $request){
        if(count($request->alumni)!=0)
        {
            $enrollee = Enrollee::find($request->enrollee_id);
            $account = Account::find($enrollee->account_id);
            $holiday = Holiday::all()->where('status','=',1);
            $message = "";
            $checkStudent = true;
            //account detail
            $checkconflict = false;
            for($i=0;$i<count($request->sprogram_id);$i++)
            {   
                $sprog = Scheduledprogram::find($request->sprogram_id[$i]);
                foreach($enrollee->classdetail as $cdetails)
                {
                    if($cdetails->trainingclass->status == 1 || $cdetails->trainingclass->status == 2 || $cdetails->trainingclass->status == 3)
                    {
                        // start of date end
                        $check = true;
                        $checkdays = 0;
                        $dateEnd = Carbon::create();
                        $dateEnd = Carbon::parse($cdetails->trainingclass->scheduledprogram->dateStart);
                        $days = $cdetails->trainingclass->scheduledprogram->rate->duration/$cdetails->trainingclass->scheduledprogram->rate->classHour;
                        while ($check) {
                            $temp = Carbon::parse($dateEnd)->format('l');
                            $holidaycheck = false;
                            foreach($holiday as $holidays){
                                if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart)->subDays(1), Carbon::parse($holidays->dateEnd)->addDays(1)) || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateStart)->format("F d, Y") || Carbon::parse($dateEnd)->format("F d, Y") == Carbon::parse($holidays->dateEnd)->format("F d, Y")){
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
                                foreach ($cdetails->trainingclass->schedule->scheduledetail as $details) {
                                    if($temp == $details->day->dayName){
                                        $checkdays++;
                                    }
                                }
                            }
                            if($days == 1)
                            {
                                $checkdays = 1;
                            }
                            if(Carbon::parse($sprog->dateStart)->eq($dateEnd)){
                                $checkconflict = true;
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
                    }
                }
            }
            for($i=0;$i<count($request->sprogram_id);$i++)
            {
                $existClass = Classdetail::where('enrollee_id','=',$request->enrollee_id)->where('trainingclass_id','=',$request->sprogram_id[$i])->get();
                if(count($existClass)>0)
                {
                    $message = "Already a student in this class";
                    $checkStudent = false;
                }
            }
            if($checkStudent)
            {
                if($checkconflict)
                {
                    $request->session()->flash('message_exist',"Conflict in student's schedule");
                    return redirect('/registercourse');
                }
                else
                {
                    for($i=0;$i<count($request->sprogram_id);$i++)
                    {
                        $accountdetail = new Accountdetail;
                        $sprog = Scheduledprogram::find($request->sprogram_id[$i]);
                        $balance = $sprog->rate->price;
                        $accountdetail->account_id = $enrollee->account_id;
                        $accountdetail->balance = $balance;
                        $accountdetail->status = 1;
                        $accountdetail->scheduledprogram_id = $request->sprogram_id[$i];
                        $accountdetail->paymentMode = $request->paymentMode[$i];
                        $accountdetail->save(); 

                        //class detail
                        $classdetail = new Classdetail;
                        $classdetail->enrollee_id = $enrollee->id;
                        $classdetail->trainingclass_id = $sprog->trainingclass->id;
                        $classdetail->save();
                    }
                    $request->session()->put('enrollee',$enrollee->id);
                    $request->session()->put('sprogram',$request->sprogram_id);
                    return redirect('/thankyou');
                }
            }
            else
            {
                $request->session()->flash('message_exist',$message);
                return redirect('/registercourse');
            }
        }
        else{
            //education background
            $message = "";
            $exist_enrollee = Enrollee::where('firstName','=',$request->firstName)->where('middleName','=',$request->middleName)->where('lastName','=',$request->lastName)->get();
            if(count($exist_enrollee)>0)
            {
                $message = "Already a student in this class";
                session()->flash('message_exist',$message);
                return redirect('/registercourse');
            }
            else
            {
                $edub = new Educationalbackground;
                $edub->attainment = $request->EBattainment;
                $edub->school = $request->EBschool;
                $edub->course = $request->EBcourse;
                $edub->save();
                $edub = Educationalbackground::All();
                $edub_last = $edub->last();

                //contact person
                $contactp = new Contactperson;
                $contactp->name = $request->Ename;
                $contactp->relationship = $request->Erel;
                $contactp->address = $request->Eaddress;
                $contactp->contact = $request->Econtact;
                $contactp->save();
                $contactp =Contactperson::all();
                $contactp_last = $contactp->last();

                //account
                $accounts = Account::all();
                $accountx = count($accounts);
                $accountx += 1;
                $account = new Account;
                $account->accountNumber = 'OC-'.Carbon::today()->format('Y').'-000'. $accountx;
                $account->save();
                $account = Account::all();
                $account_last = $account->last();

                //account detail
                for($i=0;$i<count($request->sprogram_id);$i++)
                {
                    $accountdetail = new Accountdetail;
                    $sprog = Scheduledprogram::find($request->sprogram_id[$i]);
                    $balance = $sprog->rate->price;
                    $accountdetail->account_id = $account_last->id;
                    $accountdetail->balance = $balance;
                    $accountdetail->status = 1;
                    $accountdetail->scheduledprogram_id = $request->sprogram_id[$i];
                    $accountdetail->paymentMode = $request->paymentMode[$i];
                    $accountdetail->save();
                }
                //enrollee
                $enrollee = new Enrollee;
                $enrollee->firstName = $request->firstName;
                $enrollee->middleName = $request->middleName;
                $enrollee->lastName = $request->lastName;
                $enrollee->gender = $request->gender;
                $enrollee->civilstatus_id = $request->civilStatus;
                $enrollee->dob = Carbon::parse($request->dob)->format('Y-m-d');
                $enrollee->birthPlace = $request->dop;
                $enrollee->street = $request->street;
                $enrollee->barangay = $request->barangay;
                $enrollee->city = $request->city;
                $enrollee->contact = $request->contact;
                $enrollee->email = $request->email;
                $enrollee->educationalbackground_id = $edub_last->id;
                $enrollee->contactperson_id = $contactp_last->id;
                $enrollee->account_id = $account_last->id;
                $enrollee->status_id = 1;
                $enrollee->save();
                $enrollee = Enrollee::all();
                $enrollee_last = $enrollee->last();
                $enrollee = Enrollee::find($enrollee_last->id);
                $enrollee->studentNumber = 'AP-'.Carbon::today()->format('Y').'-000'.$enrollee_last->id;
                $enrollee->save();

                //class detail
                foreach($request->sprogram_id as $sprograms)
                {
                    $classdetail = new Classdetail;
                    $classdetail->enrollee_id = $enrollee_last->id;
                    $sprog = Scheduledprogram::find($sprograms);
                    $classdetail->trainingclass_id = $sprog->trainingclass->id;
                    $classdetail->save();
                }

                //sea exp
                if($request->noYears != "" && $request->rank!="")
                {
                    $seaexp = new Seaexperience;
                    $seaexp->noYears = $request->noYears;
                    $seaexp->rank = $request->rank;
                    $seaexp->enrollee_id = $enrollee_last->id;
                    $seaexp->save();
                    $seaexp = Seaexperience::all();
                    $seaexp_last = $seaexp->last();
                }

                //training attends
                for($x = 0; $x < count($request->trainingTitle) ; $x++ )
                {
                    if($request->trainingTitle[$x] != "" && $request->trainingCenter[$x] != "" && $request->dateTaken[$x] != "")
                    {
                        $tattend = new Trainingattend;
                        $tattend->trainingTitle = $request->trainingTitle[$x];
                        $tattend->trainingCenter = $request->trainingCenter[$x];
                        $tattend->dateTaken = Carbon::parse($request->dateTaken[$x])->format('Y-m-d');
                        $tattend->enrollee_id = $enrollee_last->id;
                        $tattend->save();
                    }
                }
                $request->session()->put('enrollee',$enrollee_last->id);
                $request->session()->put('sprogram',$request->sprogram_id);
                return redirect('/thankyou');
            }
        }
        
	}

    public function thankyou(Request $request){
        $sprogs = array();
        $id = array();
        $x =0;
        $total = 0;
        if(count(session('sprogram'))>1)
        {
            foreach(session('sprogram') as $sprograms){
                $sprog = Scheduledprogram::find($sprograms);
                $sprogs[$x] =[
                    "id" => $x+1,
                    "sprogram_name" => $sprog->rate->program->programName . ' ('. $sprog->rate->duration . ' Hours)',
                ];
                $total += $sprog->rate->price;
                $x++;
                echo $sprograms;
            }
        }
        else{
            $sprog = Scheduledprogram::find(session('sprogram'));
            if(count(session('sprogram')) == 1){
                foreach($sprog as $sprog){
                    $total = $sprog->rate->price;
                    $sprogs[0] = [
                        "id" => 1,
                        "sprogram_name" => $sprog->rate->program->programName . ' ('. $sprog->rate->duration . ' Hours)',
                    ];
                }
            }
        }
        $data = array();
        $account_no = "";
        $enrollee = Enrollee::find(session('enrollee'));
        if(session()->has('enrollee')){
            $account_no = $enrollee->account->accountNumber;
        }
        $data = [
            "name" => $enrollee->firstName . ' ' .  $enrollee->middleName . ' ' . $enrollee->lastName,
            "account_no" => $account_no,
            "sprogram" => $sprogs,
            "total" => $total,
        ];
        $request->session()->put('data' , $data);
        return view('/home/thankyou');
    }

}