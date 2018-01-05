<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classdetail;
use App\Rate;
use App\Trainingofficer;
use App\Trainingclass;
use Carbon\Carbon;
use App\Scheduledprogram;
use App\Groupapplication;
use App\Groupscheduledetail;
use App\Groupschedule;
use App\Civilstatus;
use App\Groupdetail;
use App\Educationalbackground;
use App\Trainingattend;
use App\Contactperson;
use App\Seaexperience;
use App\Enrollee;
use App\Account;
use App\Day;
use App\Trainingroom;
use App\Schedule;
use App\Scheduledetail;
use App\Holiday;
use App\Accountdetail;
use App\Groupapplicationdetail;
use App\Groupenrollee;
use App\Groupclassdetail;
use App\Attendance;
use App\Refund;
use App\Nosessionday;
class EnrolleeController extends Controller
{
    //Single Application
    public function viewTrainingclass(){
        $tclass = Trainingclass::all()->where('status','=',1);
        $gtclass = $tclass;
        $gapp = Groupapplication::all();
        $tofficer = Trainingofficer::all()->where('active','=',1);
        $rate = Rate::all()->where('active','=',1);
        $gapp = Groupapplication::all();
        $tclass = Trainingclass::all()->where('status','=',1);
        $day = Day::all();
        $trainingroom = Trainingroom::all();
        $z=0;
        return view('admin/manage_application/enrollee',compact('z','rate','tofficer','gapp','day','trainingroom','tclass','gtclass'));
    }

    public function viewEnrollee(Request $request){
        $tclass = Trainingclass::find($request->id);
        $tclas = $tclass;
        return view('admin/manage_application/viewenrollee',compact('tclass','tclas'));
    }

    public function application(Request $request){
        $tclass = Trainingclass::find($request->trainingclass_id);
        $cstatus = Civilstatus::all();
        $sprogram = Scheduledprogram::all()->where('active','=',1);
        $enrollee = Enrollee::all();
        return view('admin.manage_application.application',compact('sprogram','cstatus','tclass','enrollee'));
    }

    public function insertEnrollee(Request $request){
       if(count($request->alumni)!=0)
        {
            $enrollee = Enrollee::find($request->enrollee_id);
            $holiday = Holiday::all()->where('status','=',1);
            $sessionday = Nosessionday::all();
            $sprog = Scheduledprogram::find($request->sprog_id);
            $checkconflict = false;
            foreach($enrollee->classdetail as $cdetails)
            {
                if($cdetails->trainingclass->status == 0 ||  $cdetails->trainingclass->status == 1 || $cdetails->trainingclass->status == 2 || $cdetails->trainingclass->status == 3)
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
                        foreach($sessionday as $sessiondays){
                            if(Carbon::parse($dateEnd)->between(Carbon::parse($sessiondays->dateStart), Carbon::parse($sessiondays->dateEnd))){
                                $holidaycheck = true;
                            }
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
            
            $sprog = Scheduledprogram::find($request->sprog_id);
            $account = Account::find($enrollee->account_id);
            $balance = $sprog->rate->price;
            $exist_classdetail = Classdetail::where('enrollee_id','=',$request->enrollee_id)->where('trainingclass_id','=',$request->trainingclass_id)->get();
            $message = "";

            //account detail
            if(count($exist_classdetail)>0)
            {
                $message = "Already a student in this class";
                $request->session()->flash('exist_class',$message);
                return redirect('/manage_app/enrollee/view/'.$request->trainingclass_id.'');
            }
            else
            {
                if($checkconflict == false)
                {
                    $accountdetail = new Accountdetail;
                    $accountdetail->account_id = $enrollee->account_id;
                    $accountdetail->status = 1;
                    $accountdetail->balance = $balance;
                    $accountdetail->scheduledprogram_id = $request->sprog_id;
                    $accountdetail->paymentMode = $request->paymentMode;
                    $accountdetail->save();
                    //class detail
                    $classdetail = new Classdetail;
                    $classdetail->enrollee_id = $enrollee->id;
                    $classdetail->trainingclass_id = $request->trainingclass_id;
                    $classdetail->save();

                    $sprogs= array();
                    $data = array();
                    $sprogs[0] = [
                                "id" => 1,
                                "sprogram_name" => $sprog->rate->program->programName . ' ('. $sprog->rate->duration . ' Hours)',
                            ];

                    $data = [
                        "name" => $enrollee->firstName . ' ' .  $enrollee->middleName . ' ' . $enrollee->lastName,
                        "account_no" => $account->accountNumber,
                        "sprogram" => $sprogs,
                        "total" => $balance,
                    ];
                    $request->session()->put('data' , $data);
                    $request->session()->put('voucher',1);
                    return redirect('/manage_app/enrollee/view/'.$request->trainingclass_id.'');
                }
                else
                {
                    $request->session()->flash('message',"Conflict in student's schedule");
                    return redirect('/manage_app/enrollee/view/'.$request->trainingclass_id.'');
                }
            }

        }
        else{
            $message = "";
            $exist_enrollee = Enrollee::where('firstName','=',$request->firstName)->where('middleName','=',$request->middleName)->where('lastName','=',$request->lastName)->get();
            if(count($exist_enrollee)>0)
            { 
                $message = "Already a student";
                $request->session()->flash('exist_class',$message);
                return redirect('/manage_app/enrollee/view/'.$request->trainingclass_id.'');
            }
            else
            {
                // education background
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
                $balance =0;
                $sprog = Scheduledprogram::find($request->sprog_id);
                $balance += $sprog->rate->price;
                $account->save();
                $account = Account::all();
                $account = $account->last();

                //account detail
               
                $accountdetail = new Accountdetail;
                $accountdetail->account_id = $account->id;
                $accountdetail->balance = $balance;
                $accountdetail->status = 1;
                $accountdetail->scheduledprogram_id = $sprog->id;
                $accountdetail->paymentMode = $request->paymentMode;
                $accountdetail->save();
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
                $enrollee->account_id = $account->id;
                $enrollee->status_id = 1;
                $enrollee->save();
                $enrollee = Enrollee::all();
                $enrollee_last = $enrollee->last();
                $enrollee = Enrollee::find($enrollee_last->id);
                $enrollee->studentNumber = 'AP-'.Carbon::today()->format('Y').'-000'.$enrollee_last->id;
                $enrollee->save();

                //class detail
                $classdetail = new Classdetail;
                $classdetail->enrollee_id = $enrollee_last->id;
                $classdetail->trainingclass_id = $request->trainingclass_id;
                $classdetail->save();
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
                        $tattend->dateTaken = $request->dateTaken[$x];
                        $tattend->enrollee_id = $enrollee_last->id;
                        $tattend->save();
                    }
                }
                $data = array();
                $sprogs= array();
                $sprogs[0] = [
                            "id" => 1,
                            "sprogram_name" => $sprog->rate->program->programName . ' ('. $sprog->rate->duration . ' Hours)',
                        ];

                $data = [
                    "name" => $enrollee_last->firstName . ' ' .  $enrollee_last->middleName . ' ' . $enrollee_last->lastName,
                    "account_no" => $account->accountNumber,
                    "sprogram" => $sprogs,
                    "total" => $balance,
                ];
                $request->session()->put('data' , $data);
                $request->session()->put('voucher',1);
                return redirect('/manage_app/enrollee/view/'.$request->trainingclass_id.'');
            }    
        }
    }

    //Group Application
    public function viewGEnrollee(){
    	$tofficer = Trainingofficer::all()->where('active','=',1);
    	$rate = Rate::all()->where('active','=',1);
    	$gapp = Groupapplication::all();
        $tclass = Trainingclass::all()->where('status','=',1);
        $day = Day::all();
        $trainingroom = Trainingroom::all();
        foreach($tclass as $tclasses){
        
        }
    	return view('admin/manage_application/genrollee',compact('rate','tofficer','gapp','day','trainingroom','tclass'));
    }

    public function insertGEnrollee(Request $request){
        $validdate = true;
        $message = "";
        $tofficer = Trainingofficer::find($request->tofficer_id);
        $checkconflict = false;
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
        foreach($tofficer->scheduledprogram as $classes)
        {
            // start of date end
                $check = true;
                $checkdays = 0;
                $dateEnd = Carbon::create();
                $dateEnd = Carbon::parse($classes->dateStart);
                $days = $classes->rate->duration/$classes->rate->classHour;
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
                        foreach ($classes->trainingclass->schedule->scheduledetail as $details) {
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
                    if(Carbon::parse($request->dateStart)->eq($dateEnd)){
                        $checkconflict = true;
                    }
                }
            // //end of date end 
        }
        if($checkconflict)
        {
            $validdate = false;
            $message.="Conflict of Schedule.";
        }
        if(count($request->start)!=0){
        }
        else{
            for($i=0; $i<count($request->day)-1; $i++){
                for($a = $i+1; $a<count($request->day); $a++){
                    if($request->day[$i] == $request->day[$a]){
                        $validdate = false;
                        $message.="Repeating day is not allowed.";
                        break;
                    }
                }
                if($validdate == false){
                    break;
                }
            }
        }
        if($validdate){
            $message = "New group application is successfully added";
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'success'
                );
            $rate = new Scheduledprogram;
            $rate->dateStart = Carbon::parse($request->dateStart)->format('Y-m-d');
            $rate->rate_id = $request->rate_id;
            $rate->trainingofficer_id = $request->tofficer_id;
            $rate->active=0;
            $rate->save();
            $rate= Scheduledprogram::all();
            $lastrate = $rate->last();

            $schedule = new Schedule;
            $schedule->save();
            $schedule = Schedule::all();
            $schedule = $schedule->last();

            if(count($request->start)!=0){
                for($i=$request->start; $i<=$request->end; $i++){
                    $sdetail = new Scheduledetail;
                    $sdetail->day_id = $i;
                    $sdetail->start = $request->morning;
                    $sdetail->end = Carbon::parse($request->morning)->addHours($lastrate->rate->classHour)->format('G:i');
                    $sdetail->breaktime = $request->breaktime;
                    $sdetail->schedule_id = $schedule->id;
                    $sdetail->save();
                }
            }
            else{
                $day = $request->day;
                $morning = $request->morning;
                $breaktime = $request->breaktime;
                for($i = 0; $i<count($request->day)-1;$i++)
                {
                    for($a = $i+1; $a<count($request->day);$a++)
                    {
                        if($day[$i] > $day[$a])
                        {
                            $temp = $day[$i];
                            $tempm = $morning[$i];
                            $tempb = $breaktime[$i];
                            $day[$i] = $day[$a];
                            $day[$a] = $temp;
                            $morning[$i] = $morning[$a];
                            $morning[$a] = $tempm;
                            $breaktime[$i] = $breaktime[$a];
                            $breaktime[$a] = $tempb;

                        }
                    }
                }
                for($i=0; $i<count($request->day); $i++){
                    $sdetail = new Scheduledetail;
                    $sdetail->day_id = $day[$i];
                    $sdetail->start = $morning[$i];
                    $sdetail->end = Carbon::parse($morning[$i])->addHours($lastrate->rate->classHour)->format('G:i');
                    $sdetail->breaktime = $breaktime[$i];
                    $sdetail->schedule_id = $schedule->id;
                    $sdetail->save();
                }
            }
            $class = new Trainingclass;
            $class->class_name = 'Class ' . $lastrate->id;
            $class->scheduledprogram_id = $lastrate->id;
            $class->trainingroom_id = $request->trainingroom_id;
            $class->schedule_id = $schedule->id;
            $class->save();
            $class = Trainingclass::all();
            $class_last = $class->last();

            $attendance = new Attendance;
            $attendance->trainingclass_id = $class_last->id;
            $attendance->save();
            if(count($request->org_id)>0)
            {
                $gapp = Groupapplication::find($request->org_id);

                $accountdetail = new Accountdetail;
                $accountdetail->account_id = $gapp->account_id;
                $accountdetail->balance = 0;
                $accountdetail->scheduledprogram_id = $lastrate->id;
                $accountdetail->paymentMode = $request->paymentMode;;
                $accountdetail->save();

                $groupappdetail =  new Groupapplicationdetail;
                $groupappdetail->groupapplication_id = $gapp->id;
                $groupappdetail->trainingclass_id = $class_last->id;
                $groupappdetail->save();

                return redirect('/manage_app/enrollee')->with($notification);
            }
            else{
                $accounts = Account::all();
                $accountx = count($accounts);
                $accountx += 1;
                $account = new Account;
                $account->accountNumber = 'OC-'.Carbon::today()->format('Y').'-000'. $accountx;
                $account->save();
                $account = Account::all();
                $account = $account->last();

                $accountdetail = new Accountdetail;
                $accountdetail->account_id = $account->id;
                $accountdetail->balance = 0;
                $accountdetail->scheduledprogram_id = $lastrate->id;
                $accountdetail->paymentMode = $request->paymentMode;;
                $accountdetail->save();

                $gapp = new Groupapplication;
                $gapp->orgName = $request->orgName;
                $gapp->orgAddress = $request->orgAddress;
                $gapp->orgRepresentative = $request->orgRepresentative;
                $gapp->account_id = $account->id;
                $gapp->save();
                $gapp = Groupapplication::all();
                $gapp = $gapp->last();

                $groupappdetail =  new Groupapplicationdetail;
                $groupappdetail->groupapplication_id = $gapp->id;
                $groupappdetail->trainingclass_id = $class_last->id;
                $groupappdetail->save();
                return redirect('/manage_app/enrollee')->with($notification);
            }
        }
        else{
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            return redirect('/manage_app/enrollee')->with($notification);
        }
		
    }

    public function updateGEnrollee(Request $request){
        $validdate = true;
        $message = "";
        $tofficer = Trainingofficer::find($request->tofficer_id);
        $checkconflict = false;
        $holiday = Holiday::all()->where('active','=',1);
        $tclass = Trainingclass::find($request->trainingclass_id);
        $sessionday = Nosessionday::all();
        foreach($tofficer->scheduledprogram as $classes)
        {
            if($tclass->scheduledprogram->id != $classes->id)
            {
                // start of date end
                    $check = true;
                    $checkdays = 0;
                    $dateEnd = Carbon::create();
                    $dateEnd = Carbon::parse($classes->dateStart);
                    $days = $classes->rate->duration/$classes->rate->classHour;
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
                            foreach ($classes->trainingclass->schedule->scheduledetail as $details) {
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
                        if(Carbon::parse($request->dateStart)->eq($dateEnd)){
                            $checkconflict = true;
                        }
                    }
                // //end of date end
            }
        }
        if($checkconflict)
        {
            $validdate = false;
            $message.="Conflict of Schedule.";
        }
        if(count($request->start)!=0){
            
        }
        else{
            for($i=0; $i<count($request->day)-1; $i++){
                for($a = $i+1; $a<count($request->day); $a++){
                    if($request->day[$i] == $request->day[$a]){
                        $validdate = false;
                        $message.="Repeating day is not allowed.";
                        break;
                    }
                }
                if($validdate == false){
                    break;
                }
            }
        }
        if($validdate){
            $message = "Group application is successfully updated";
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'success'
                );
            $rate = $tclass->scheduledprogram;
            $rate->dateStart = Carbon::parse($request->dateStart)->format('Y-m-d');
            $rate->rate_id = $request->rate_id;
            $rate->trainingofficer_id = $request->tofficer_id;
            $rate->save();

            $schedule = $tclass->schedule;
            foreach($schedule->scheduledetail as $details)
            {
                $sdetails = Scheduledetail::find($details->id);
                $sdetails->delete();
            }
            if(count($request->start)!=0){
                for($i=$request->start; $i<=$request->end; $i++){
                    $sdetail = new Scheduledetail;
                    $sdetail->day_id = $i;
                    $sdetail->start = $request->morning;
                    $sdetail->end = Carbon::parse($request->morning)->addHours($rate->rate->classHour)->format('G:i');
                    $sdetail->breaktime = $request->breaktime;
                    $sdetail->schedule_id = $tclass->schedule_id;
                    $sdetail->save();
                }
            }
            else{
                $day = $request->day;
                $morning = $request->morning;
                $breaktime = $request->breaktime;
                for($i = 0; $i<count($request->day)-1;$i++)
                {
                    for($a = $i+1; $a<count($request->day);$a++)
                    {
                        if($day[$i] > $day[$a])
                        {
                            $temp = $day[$i];
                            $tempm = $morning[$i];
                            $tempa = $afternoon[$i];
                            $tempb = $breaktime[$i];
                            $day[$i] = $day[$a];
                            $day[$a] = $temp;
                            $morning[$i] = $morning[$a];
                            $morning[$a] = $tempm;
                            $breaktime[$i] = $breaktime[$a];
                            $breaktime[$a] = $tempb;

                        }
                    }
                }
                for($i=0; $i<count($request->day); $i++){
                    $sdetail = new Scheduledetail;
                    $sdetail->day_id = $day[$i];
                    $sdetail->start = $morning[$i];
                    $sdetail->end = Carbon::parse($morning[$i])->addHours($rate->rate->classHour)->format('G:i');
                    $sdetail->breaktime = $breaktime[$i];
                    $sdetail->schedule_id = $tclass->schedule_id;
                    $sdetail->save();
                }
            }

            $gapp = $tclass->groupapplicationdetail->groupapplication;
            $gapp->orgName = $request->orgName;
            $gapp->orgAddress = $request->orgAddress;
            $gapp->orgRepresentative = $request->orgRepresentative;
            $gapp->save();
            return redirect('/manage_app/enrollee')->with($notification);
        }
        else{
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            return redirect('/manage_app/enrollee')->with($notification);
        }
        
    }

    public function markGroupEnrollee(Request $request)
    {
        $gapp = Groupapplicationdetail::find($request->id);
        $account = Account::find($gapp->groupapplication->account_id);
        $detailaccount = Accountdetail::where('account_id','=', $account->id )
                        ->where('scheduledprogram_id','=',$gapp->trainingclass->scheduledprogram->id)->first();
        $accountdetail = Accountdetail::find($detailaccount->id);
        $balance = $accountdetail->balance;
        $balance += count($gapp->trainingclass->groupclassdetail)*$gapp->trainingclass->scheduledprogram->rate->price;
        $accountdetail->balance = $balance;
        $accountdetail->save();
        $tclass = $gapp->trainingclass;
        if(count($tclass->groupclassdetail)>=$tclass->scheduledprogram->rate->min_students)
        {
            $gapp->application_status = 2;
            $gapp->save();
            $notification = array(
                    'message' => "Successfully finalized this class", 
                    'alert-type' => 'success'
                );
            return redirect('/manage_app/genrollee/view/'.$tclass->id.'');    
        }
        else
        {
            $notification = array(
                    'message' => "Number of students must be greater than minimun students", 
                    'alert-type' => 'warning'
                );
            return redirect('/manage_app/genrollee/view/'.$tclass->id.'');
        }
    }

    public function viewGroupEnrollee(Request $request){
        $tclass = Trainingclass::find($request->id);
        /*
        $schedule="";
        foreach ($gapp->groupschedule->groupscheduledetail as $detail) {
            if($gapp->groupschedule->groupscheduledetail->last() == $detail)
            {
                $schedule .= $detail->day->dayName;
            }
            else
            {
                $schedule .=$detail->day->dayName . '-';
            }
        }
        $schedule .= '   '. Carbon::parse($gapp->groupschedule->start)->format('g:i A');
        $schedule .= ' - '. Carbon::parse($gapp->groupschedule->end)->format('g:i A');
        */
        return view('admin/manage_application/viewgenrollee',compact('tclass'));
    }

    public function viewGApplication(Request $request){
        $groupapplication_id = $request->id;
        $groupappdetail = Groupapplicationdetail::find($request->id);
        $student = $groupappdetail->groupapplication->groupdetail;
        $cstatus = Civilstatus::all();
        return view('admin/manage_application/gapplication',compact('groupapplication_id','cstatus','student'));
    }

    public function insertGApplication(Request $request){
        $groupappdetail = Groupapplicationdetail::find($request->groupapplication_id);
        if(count($request->groupenrollee_id)==0)
        {
            //check if the student data already exist
            $exist_enrollee = Groupenrollee::where('firstName','=',$request->firstName)->where('middleName','=',$request->middleName)->where('lastName','=',$request->lastName)->get();

            if(count($exist_enrollee)>0)
            {
                $request->session()->flash('error_message','Already a trainee');
                return redirect('/manage_app/genrollee/view/'.$groupappdetail->trainingclass_id.'');
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
                $contactp->contact = $request->contact;
                $contactp->save();
                $contactp =Contactperson::all();
                $contactp_last = $contactp->last();
                //enrollee

                $enrolleex = Groupenrollee::all();
                $enrolleex = count($enrolleex)+1;
                $enrollee = new Groupenrollee;
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
                $enrollee->studentNumber = 'GA-'.Carbon::today()->format('Y').'-000'.$enrolleex;
                $enrollee->save();
                $enrollee = Groupenrollee::all();
                $enrollee_last = $enrollee->last();

                $groupapp = new Groupdetail;
                $groupapp->groupapplication_id = $groupappdetail->groupapplication_id;
                $groupapp->groupenrollee_id = $enrollee_last->id;
                $groupapp->save();


                $groupclassdetail = new Groupclassdetail;
                $groupclassdetail->groupenrollee_id = $enrollee_last->id;
                $groupclassdetail->trainingclass_id = $groupappdetail->trainingclass_id;
                $groupclassdetail->save();

                $request->session()->flash('success_message','Successfully added new trainee');
                return redirect('/manage_app/genrollee/view/'.$groupappdetail->trainingclass_id.'');
            }
        }
        else{
            $enrollee = Groupenrollee::find($request->groupenrollee_id);
            $holiday = Holiday::all()->where('status','=',1);
            $sprog = Scheduledprogram::find($groupappdetail->trainingclass_id);
            $checkconflict = false;
            //check if conflict in student schedule
            foreach($enrollee->groupclassdetail as $cdetails)
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
            //check if the student already exist in the class
            $exist_classdetail = Groupclassdetail::where('groupenrollee_id','=',$request->groupenrollee_id)->where('trainingclass_id','=',$groupappdetail->trainingclass_id)->get();

            if(count($exist_classdetail)>0)
            {
                $request->session()->flash('error_message','Already a trainee in this class');
                return redirect('/manage_app/genrollee/view/'.$groupappdetail->trainingclass_id.'');
            }
            else
            {
                if($checkconflict)
                {
                    $request->session()->flash('error_message',"Conflict in this trainee's schedule.");
                    return redirect('/manage_app/genrollee/view/'.$groupappdetail->trainingclass_id.'');
                }
                else
                {
                    $groupclassdetail = new Groupclassdetail;
                    $groupclassdetail->groupenrollee_id = $request->groupenrollee_id;
                    $groupclassdetail->trainingclass_id = $groupappdetail->trainingclass_id;
                    $groupclassdetail->save();
                    $request->session()->flash('success_message',"Successfully added new trainee");
                    return redirect('/manage_app/genrollee/view/'.$groupappdetail->trainingclass_id.'');
                }
            }
        }


        //return redirect('/manage_app/genrollee/view/'.$groupappdetail->trainingclass_id.'');
    }

    public function getOrg(Request $request){
        $data = Groupapplication::find($request->group_id);
        return response()->json($data);
    }

    public function getGroupenrollee(Request $request){
        $data = Groupenrollee::where('id',$request->groupenrollee_id)->first();
        $alldata = array();
        if(count($data)>0){            
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
            ];
        }
        return response()->json($alldata);
    }

    public function cancelEnrollee(Request $request)
    {
        $classdetail = Classdetail::find($request->classdetail_id);
        $accountdetail = Accountdetail::where('account_id','=',$classdetail->enrollee->account->id)->where('scheduledprogram_id','=',$classdetail->trainingclass_id)->first();
        if($classdetail->status != 1)
        {
            $refund = new Refund;
            $refund->enrollee_id = $classdetail->enrollee->id;
            $refund->trainingclass_id = $classdetail->trainingclass->id;
            $refund->amount = $classdetail->trainingclass->scheduledprogram->rate->price - $accountdetail->balance; 
            $refund->date = Carbon::today()->format('Y-m-d');
            $refund->save();
        }        
        $accountD = Accountdetail::find($accountdetail->id);
        $accountD->delete();
        $classdetail->delete();
        return redirect('/manage_app/enrollee/view/'.$classdetail->trainingclass->id.'');
    }
}
