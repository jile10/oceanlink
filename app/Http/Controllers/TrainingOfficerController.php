<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate;
use App\Trainingofficer;
use App\Scheduledprogram;
use App\classdetail;
use App\Groupapplication;
use App\Enrollee;
use Carbon\Carbon;
use App\Building;
use App\Floor;
use App\Vessel;
use App\Enrollmentreport;
use App\Attend;
use Auth;
use App\Civilstatus;
use App\Educationalbackground;
use App\Contactperson;
use App\Seaexperience;
use App\Trainingclass;
use App\Holiday;
use App\Groupattend;
use App\Scheduledetail;
use App\Grade;
use App\Groupgrade;
use App\Groupclassdetail;
use App\Nosessionday;
use App\User;
use Image;
class TrainingOfficerController extends Controller
{

    public function viewClass(){
        $tclass = Trainingclass::all();
        $detail = Classdetail::All();
        $officer = Trainingofficer::find(Auth::user()->trainingofficer->id);
        $enrollee = Enrollee::all();
        $x = 0;
        return view('/training_officer/home',compact('class','officer'));
    }

    public function setClass(Request $request){
        session()->put('class_tclass_id',$request->tclass_id);
        return redirect('/tofficer/class');
    }

    public function Classes(Request $request)
    {
        $tclass = Trainingclass::where('id','=',session('class_tclass_id'))->first();
        $cstatus = Civilstatus::all();
        $x=0;
        return view('/training_officer/class',compact('x','tclass','cstatus'));
    }

    public function updateEnrollee(Request $request)
    {
        $enrollee_exist = Enrollee::where('firstName','=',$request->firstName)->where('middleName','=',$request->middleName)->where('lastName','=',$request->lastName)->where('id','!=',$request->enrollee_id)->get();
        $email_exist = Enrollee::where('email','=',$request->email)->where('id','!=',$request->enrollee_id)->get();

        if(count($enrollee_exist)==0)
        {
            if(count($email_exist)==0)
            {
                // education background
                $edub = Educationalbackground::find($request->educationalbackground_id);
                $edub->attainment = $request->EBattainment;
                $edub->school = $request->EBschool;
                $edub->course = $request->EBcourse;
                $edub->save();

                //contact person
                $contactp = Contactperson::find($request->contactperson_id);
                $contactp->name = $request->Ename;
                $contactp->relationship = $request->Erel;
                $contactp->address = $request->Eaddress;
                $contactp->contact = $request->Econtact;
                $contactp->save();
               
               //enrollee
                $enrollee = Enrollee::find($request->enrollee_id);
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
                $enrollee->educationalbackground_id = $request->educationalbackground_id;
                $enrollee->contactperson_id = $request->contactperson_id;
                $enrollee->save();        

                if(count($request->seaexperience_id)==0)
                {
                    //sea exp
                    if($request->noYears != "" && $request->rank!="")
                    {
                        $seaexp = new Seaexperience;
                        $seaexp->noYears = $request->noYears;
                        $seaexp->rank = $request->rank;
                        $seaexp->enrollee_id = $request->enrollee_id;
                        $seaexp->save();
                    }
                }
                else
                {
                    //sea exp
                    if($request->noYears != "" && $request->rank!="")
                    {
                        $seaexp = Seaexperience::find($request->seaexperience_id);
                        $seaexp->noYears = $request->noYears;
                        $seaexp->rank = $request->rank;
                        $seaexp->enrollee_id = $request->enrollee_id;
                        $seaexp->save();
                    }
                }
                //training attends
                if(count($request->trainingattend_id)==0)
                {
                    for($x = 0; $x < count($request->trainingTitle) ; $x++ )
                    {
                        if($request->trainingTitle[$x] != "" && $request->trainingCenter[$x] != "" && $request->dateTaken[$x] != "")
                        {
                            $tattend = new Trainingattend;
                            $tattend->trainingTitle = $request->trainingTitle[$x];
                            $tattend->trainingCenter = $request->trainingCenter[$x];
                            $tattend->dateTaken = $request->dateTaken[$x];
                            $tattend->enrollee_id = $request->enrollee_id;
                            $tattend->save();
                        }
                    }
                }
                else
                {
                    foreach($request->trainingattend_id as $id)
                    {
                        $tattend = Trainingattend::find($id);
                        $tattend->delete();
                    }
                    for($x = 0; $x < count($request->trainingTitle) ; $x++ )
                    {
                        if($request->trainingTitle[$x] != "" && $request->trainingCenter[$x] != "" && $request->dateTaken[$x] != "")
                        {
                            $tattend = new Trainingattend;
                            $tattend->trainingTitle = $request->trainingTitle[$x];
                            $tattend->trainingCenter = $request->trainingCenter[$x];
                            $tattend->dateTaken = $request->dateTaken[$x];
                            $tattend->enrollee_id = $request->enrollee_id;
                            $tattend->save();
                        }
                    }

                }
                $notification = array(
                    'message' => "Trainee's information has been updated", 
                    'alert-type' => 'success'
                );
                return redirect('/tofficer/class')->with($notification);
            }
            else
            {
                $notification = array(
                    'message' => "Email already exist", 
                    'alert-type' => 'error'
                );
                return redirect('/tofficer/class')->with($notification);
            }
        }
        else
        {
            $notification = array(
                'message' => "Trainee already exist", 
                'alert-type' => 'error'
            );
            return redirect('/tofficer/class')->with($notification);
        }

    }

    public function updateClass(Request $request)
    {
        $tclass = Trainingclass::whereId($request->pk)->first();
        $tclass->class_name = $request->value;
        if($tclass->save())
        {
            return response()->json(array('message'=>"Class name has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Canno update name",'alert-type'=>'error'));
        }
    }

    public function viewAttendance(){
        $tclass = Trainingclass::where('id','=',session('class_tclass_id'))->first();
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
        return view('training_officer/attendance',compact('tclass','dateEnd'));
    }

    public function viewGrade(){
        $tclass = Trainingclass::where('id','=',session('class_tclass_id'))->first();
        $i = 0;
        return view('training_officer/grade',compact('tclass','i'));
    }

    public function insertAttendance(Request $request)
    {
        $checkattendance = false; 
        $tclass = Trainingclass::find($request->trainingclass_id);
        $holiday = Holiday::all()->where('active','=',1);
        // start of date end
        //end of date end
        $attendanceholidaycheck = true;
        foreach($holiday as $holidays){
            if(Carbon::parse($request->attendanceDate)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)) || Carbon::parse($request->attendanceDate)->format("F d, Y") == Carbon::parse($holidays->dateStart)->format("F d, Y") || Carbon::parse($request->attendanceDate)->format("F d, Y") == Carbon::parse($holidays->dateEnd)->format("F d, Y")){
                $attendanceholidaycheck = false;
            }
        }
        if(Carbon::parse($request->attendanceDate)->between(Carbon::parse($tclass->scheduledprogram->dateStart),Carbon::parse($request->attendanceDate)) || Carbon::parse($request->attendanceDate)->eq(Carbon::parse($tclass->scheduledprogram->dateStart)) || Carbon::parse($request->attendanceDate)->eq(Carbon::parse($request->attendanceDate)))
        {
            foreach ($tclass->schedule->scheduledetail as $details) {
                if(Carbon::parse($request->attendanceDate)->format('l')== $details->day->dayName){
                    $checkattendance = true;
                }
            }
        }
        $check = Nosessionday::where('date',Carbon::parse($request->attendanceDate)->format('Y-m-d'))->get();
        if(count($check)>0)
        {
            $notification = array(
                    'message' => 'Cannot set attendance in this day', 
                    'alert-type' => 'error'
                );
                return redirect('/tofficer/class/attendance')->with($notification);
        }
        else
        {
            if($checkattendance && $attendanceholidaycheck){
                if($request->checkAttendance == 0)
                {
                    if(count($request->classdetail_id)!=0)
                    {  
                        for($i=0;$i<count($request->classdetail_id);$i++){
                            $attend = new Attend;
                            $attend->date = Carbon::parse($request->attendanceDate)->format('Y-m-d');
                            $attend->status = $request->status[$i];
                            $attend->attendance_id = $tclass->attendance->id;
                            $attend->classdetail_id = $request->classdetail_id[$i];
                            $attend->save();
                        }
                    }
                    else
                    {
                        for($i=0;$i<count($request->groupclassdetail_id);$i++){
                            $attend = new Groupattend;
                            $attend->date = Carbon::parse($request->attendanceDate)->format('Y-m-d');
                            $attend->status = $request->status[$i];
                            $attend->attendance_id = $tclass->attendance->id;
                            $attend->groupclassdetail_id = $request->groupclassdetail_id[$i];
                            $attend->save();
                        }
                    }
                    $notification = array(
                        'message' => 'Attendance in this day has been set', 
                        'alert-type' => 'success'
                    );
                    return redirect('/tofficer/class/attendance')->with($notification);
                }
                else
                {
                    if(count($request->classdetail_id)!=0)
                    {  
                        for($i=0;$i<count($request->classdetail_id);$i++){
                            $attend = Attend::where('date','=',Carbon::parse($request->attendanceDate)->format('Y-m-d'))->where('classdetail_id','=',$request->classdetail_id[$i])->get();
                            foreach($attend as $attends)
                            {
                                $atten = Attend::find($attends->id);
                                $atten->status = $request->status[$i];
                                $atten->save();
                            }
                        }
                    }
                    else
                    {
                        for($i=0;$i<count($request->groupclassdetail_id);$i++){
                            $attend = Groupattend::where('date','=',Carbon::parse($request->attendanceDate)->format('Y-m-d'))->where('classdetail_id','=',$request->groupclassdetail_id[$i])->get();
                            foreach($attend as $attends)
                            {
                                $atten = Groupattend::find($attends->id);
                                $atten->status = $request->status[$i];
                                $atten->save();
                            }
                        }
                    }
                    $notification = array(
                        'message' => 'Attendance in this day has been updated', 
                        'alert-type' => 'success'
                    );
                    return redirect('/tofficer/class/attendance')->with($notification);
                }
            }
            else
            {
                $notification = array(
                    'message' => "Cannot set attendance in this day.", 
                    'alert-type' => 'error'
                );
                return redirect('/tofficer/class/attendance')->with($notification);
            }
        }
    }

    public function insertGrade(Request $request)
    {
         if(count($request->classdetail_id)>0)
        {
            if(count($request->updateGrade) == 1)
            {
                $a = count($request->classdetail_id);
                for($i = 0; $i < $a ; $i++)
                {
                    $detail = Classdetail::find($request->classdetail_id[$i]);
                    $grade = Grade::find($detail->grade->id);
                    $grade->grade = strtoupper($request->grade[$i]);
                    $grade->remark = $request->remark[$i];
                    $grade->save();
                }

                $notification = array(
                    'message' => 'Grade in this class has been updated', 
                    'alert-type' => 'success'
                );
                return redirect('/tofficer/class/grade')->with($notification);
            }
            else
            {
                $a = count($request->classdetail_id);
                for($i = 0; $i < $a ; $i++)
                {
                    $grade = new Grade;
                    $grade->grade = strtoupper($request->grade[$i]);
                    $grade->classdetail_id = $request->classdetail_id[$i];
                    $grade->remark = $request->remark[$i];
                    $grade->save();
                }

                $notification = array(
                    'message' => 'Grade in this class has been set', 
                    'alert-type' => 'success'
                );
                return redirect('/tofficer/class/grade')->with($notification);
            }
        }
        else
        {
            for($i = 0; $i<count($request->groupclassdetail_id);$i++)
            {
                $grade = new Groupgrade;
                $grade->grade = strtoupper($request->grade[$i]);
                $grade->groupclassdetail_id = $request->groupclassdetail_id[$i];
                $grade->remark = $request->remark[$i];
                $grade->save();
            }

            $notification = array(
                'message' => 'Grade in this class has been set', 
                'alert-type' => 'success'
            );
            return redirect('/tofficer/class/grade')->with($notification);
        }
    }

    public function viewAccount(){
        return view('/training_officer/accountsetting');
    }

    // Ajax
    public function updateImage(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save( public_path('display_image/'.$filename));

            $tofficer = Auth::user()->trainingofficer;
            $tofficer->image = $filename;
            $tofficer->save();

            return redirect('/tofficer/accountsetting');
        }
    }

    public function updateFirstName(Request $request)
    {
        $tofficer = Auth::user()->trainingofficer;
        $tofficer->firstName = $request->firstName;
        $tofficer->middleName = $request->middleName;
        $tofficer->lastName = $request->lastName;
        if($tofficer->save())
        {
            return response()->json(array('message'=>"Full Name has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateAddress(Request $request)
    {
        $tofficer = Auth::user()->trainingofficer;
        $tofficer->street = $request->street;
        $tofficer->barangay = $request->barangay;
        $tofficer->city = $request->city;
        if($tofficer->save())
        {
            return response()->json(array('message'=>"Address has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $user->email = $request->email;
        if($user->save())
        {
            return response()->json(array('message'=>"Email has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateDob(Request $request)
    {
        $tofficer = Auth::user()->trainingofficer;
        $tofficer->dob = Carbon::parse($request->dob)->format('Y-m-d');
        if($tofficer->save())
        {
            return response()->json(array('message'=>"Date of birth has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateContact(Request $request)
    {
        $tofficer = Auth::user()->trainingofficer;
        $tofficer->contact = $request->contact;
        if($tofficer->save())
        {
            return response()->json(array('message'=>"Date of birth has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }
}
