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
use App\Nosessionday;
class ReceptionistController extends Controller
{
    public function home(){
    	$tclass = Trainingclass::all()->where('status','=',1);
        $gtclass = $tclass;
        $gapp = Groupapplication::all();
        $tofficer = Trainingofficer::all()->where('active','=',1);
        $rate = Rate::all()->where('active','=',1);
        $tclass = Trainingclass::all()->where('status','=',1);
        $day = Day::all();
        $trainingroom = Trainingroom::all();
        $z=0;
        return view('receptionist/home',compact('z','rate','tofficer','gapp','day','trainingroom','tclass','gtclass'));
    }

    public function SNextStep(Request $request){
    	$request->session()->forget('trainingclass_id');
    	$request->session()->put('trainingclass_id',$request->trainingclass_id);
        $tclass = Trainingclass::find($request->trainingclass_id);
        if(count($tclass->groupapplicationdetail)==0)
    		return redirect('/receptionist/manage_enrollment/single/view');
    	else
    		return redirect('/receptionist/manage_enrollment/group/view');

    }

    public function viewSingleClass(){
        $tclass = Trainingclass::find(session('trainingclass_id'));
        $tclas = $tclass;
        return view('receptionist/class',compact('tclass','tclas'));
    }

    public function SApplication(){
        $tclass = Trainingclass::find(session('trainingclass_id'));
        $cstatus = Civilstatus::all();
        $sprogram = Scheduledprogram::all()->where('active','=',1);
        $enrollee = Enrollee::all();
        return view('receptionist/application',compact('sprogram','cstatus','tclass','enrollee'));
    }

    public function insertSApplication(Request $request)
    {
    	if(count($request->alumni)!=0)
        {
            $enrollee = Enrollee::find($request->enrollee_id);
            $holiday = Holiday::all()->where('status','=',1);
            $sessionday = Nosessionday::all();
            $sprog = Scheduledprogram::find($request->sprog_id);
            $checkconflict = false;
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
                return redirect('/receptionist/manage_enrollment/single/view');
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
                    $request->session()->flash('data' , $data);
                    $request->session()->flash('voucher',1);
                    return redirect('/receptionist/manage_enrollment/single/view');
                }
                else
                {
                    $request->session()->flash('message',"Conflict in student's schedule");
                	return redirect('/receptionist/manage_enrollment/single/view');                
                }
            }

        }
        else{
            $message = "";
            $exist_enrollee = Enrollee::where('firstName','=',$request->firstName)->where('middleName','=',$request->middleName)->where('lastName','=',$request->lastName)->get();
            if(count($exist_enrollee)>0)
            { 
                $message = "Already a student in this class";
                $request->session()->flash('exist_class',$message);
                return redirect('/receptionist/manage_enrollment/single/view');
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
                return redirect('/receptionist/manage_enrollment/single/view');
            }    
        }
    }

    public function viewGroupClass(Request $request){
		$tclass = Trainingclass::find(session('trainingclass_id'));
        return view('receptionist/groupclass',compact('tclass'));

    }

    public function insertGroup(Request $request)
    {
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
            if($request->start>$request->end)
            {
                $validdate = false;
                $message.="Invalid date range.";
            }
            if(Carbon::parse($request->morning)->gte(Carbon::parse($request->afternoon)))
            {
                $validdate = false;
                $message.="Invalid time.";
            }
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
            for($i=0; $i<count($request->day); $i++){
                if(Carbon::parse($request->morning[$i])->gte(Carbon::parse($request->afternoon[$i])))
                {
                    $validdate = false;
                    $message.="Invalid Time.";
                    break;
                }
            }
        }
        if($validdate){
            $check_exist = true;
            if(count($request->org_id)==0)
            {
                $exist_group = Groupapplication::where('orgName','=',$request->orgName)->first();
                if(count($exist_group)>0)
                {
                    $check_exist = false;
                }
            }
            if($check_exist)
            {
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
                        $sdetail->end = $request->afternoon;
                        $sdetail->breaktime = $request->breaktime;
                        $sdetail->schedule_id = $schedule->id;
                        $sdetail->save();
                    }
                }
                else{
                    for($i=0; $i<count($request->day); $i++){
                        $sdetail = new Scheduledetail;
                        $sdetail->day_id = $request->day[$i];
                        $sdetail->start = $request->morning[$i];
                        $sdetail->end = $request->afternoon[$i];
                        $sdetail->breaktime = $request->breaktime[$i];
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

                    return redirect('/receptionist')->with($notification);
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

                    return redirect('/receptionist')->with($notification);
                }
            }
            else
            {
                $notification = array(
                    'message' => "Organization already exist", 
                    'alert-type' => 'warning'
                );
                return redirect('/receptionist')->with($notification);
            }
        }
        else{
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            return redirect('/receptionist')->with($notification);
        }
    }

    public function finalizeGroup(Request $request){
        $detail = Groupapplicationdetail::find($request->id);
        $detail->application_status = 2;
        $detail->save();
        $notification = array(
                    'message' => "Successfully finalize group application", 
                    'alert-type' => 'success'
                );
        return redirect('/receptionist')->with($notification);

    }

    public function GApplication(){
        $tclass = Trainingclass::find(session('trainingclass_id'));
        $groupapplication_id = $tclass->groupapplicationdetail->id;
        $groupappdetail = Groupapplicationdetail::find($tclass->groupapplicationdetail->id);
        $student = $groupappdetail->groupapplication->groupdetail;
        $cstatus = Civilstatus::all();
        return view('admin/manage_application/gapplication',compact('groupapplication_id','cstatus','student'));
    }

    public function insertGApplication(Request $request){
    	$groupappdetail = Groupapplicationdetail::find($request->groupapplication_id);
        $account = Account::find($groupappdetail->groupapplication->account_id);
        $detailaccount = Accountdetail::where('account_id','=', $account->id )
                        ->where('scheduledprogram_id','=',$groupappdetail->trainingclass->scheduledprogram->id)->first();
        $accountdetail = Accountdetail::find($detailaccount->id);
        $balance = $accountdetail->balance;
        $balance += $groupappdetail->trainingclass->scheduledprogram->rate->price;
        $accountdetail->balance = $balance;
        $accountdetail->save();
        if(count($request->groupenrollee_id)==0)
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
        }
        else{

            $groupclassdetail = new Groupclassdetail;
            $groupclassdetail->groupenrollee_id = $request->groupenrollee_id;
            $groupclassdetail->trainingclass_id = $groupappdetail->trainingclass_id;
            $groupclassdetail->save();
        }


        return redirect('/receptionist/manage_enrollment/group/view');
    }

    public function viewAccount(){
        return view('receptionist.accountsetting');
    }

    public function updateImage(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save( public_path('display_image/'.$filename));

            $employee = Auth::user()->employee;
            $employee->image = $filename;
            $employee->save();

            return redirect('/receptionist/accountsetting');
        }
    }
}
