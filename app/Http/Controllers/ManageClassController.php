<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trainingclass;
use Carbon\Carbon;
use App\Holiday;
use App\Attend;
use App\Groupattend;
use App\Scheduledetail;
use App\Grade;
use App\Groupgrade;
use App\Classdetail;
use App\Groupclassdetail;
use App\Nosessionday;
class ManageClassController extends Controller
{
    public function viewClass(){
        $x=0;
        $y=0;
        $class = Trainingclass::where('status','=',2)->orWhere('status','=',4)->get();
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
                if(count(Scheduledetail::where('schedule_id','=',$classes->schedule->id)->get())>0){
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
            //end of schedule
            $tclass[$x] = [
                'id' => $classes->scheduledprogram->id,
                'class_name' =>$classes->class_name,
                'course_name' => $classes->scheduledprogram->rate->program->programName . ' (' . $classes->scheduledprogram->rate->duration . ' Hours) ',
                'dateStart' =>Carbon::parse($classes->scheduledprogram->dateStart)->format("F d, Y"),
                'dateEnd' => Carbon::parse($dateEnd)->format("F d, Y"),
                'officer' => $classes->scheduledprogram->trainingofficer->firstName . ' ' . $classes->scheduledprogram->trainingofficer->middleName . ' ' . $classes->scheduledprogram->trainingofficer->lastName,
                'sched' => $schedules,
            ];
            $x++;
        }
    	return view("admin/manage_class/class",compact('tclass'));
    }

    public function setGrade(Request $request){
    	$request->session()->put('id',$request->id);
    	return redirect('/manage_class/grade');
    }

    public function setAttendance(Request $request){
    	$request->session()->put('id',$request->id);
    	return redirect('/manage_class/attendance');
    }

    public function viewGrade(Request $request){
    	$id  = session('id');
    	$tclass = Trainingclass::find($id);
        $i = 0;
    	return view('admin/manage_class/grade',compact('tclass','i'));
    }

    public function viewAttendance(Request $request){
    	$id  = session('id');
    	$tclass = Trainingclass::find($id);
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
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
                foreach($sessionday as $sessiondays){
                    if(Carbon::parse($dateEnd)->between(Carbon::parse($sessiondays->dateStart), Carbon::parse($sessiondays->dateEnd))){
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
    	return view('admin/manage_class/attendance',compact('tclass','dateEnd'));
    }

    public function insertAttendance(Request $request){
        $checkattendance = false; 
        $tclass = Trainingclass::find($request->trainingclass_id);
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
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
            foreach($sessionday as $sessiondays){
                if(Carbon::parse($dateEnd)->between(Carbon::parse($sessiondays->dateStart), Carbon::parse($sessiondays->dateEnd))){
                    $notification = array(
                            'message' => 'Cannot set attendance in this day', 
                            'alert-type' => 'error'
                        );
                        return redirect('/manage_class/attendance')->with($notification);
                }
            
            }
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
                    return redirect('/manage_class/attendance')->with($notification);
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
                    return redirect('/manage_class/attendance')->with($notification);
                }
            }
            else
            {
                $notification = array(
                    'message' => "Cannot set attendance in this day.", 
                    'alert-type' => 'error'
                );
                return redirect('/manage_class/attendance')->with($notification);
            }
        }
    }
    public function insertGrade(Request $request){
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
                return redirect('/manage_class/grade')->with($notification);
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
                return redirect('/manage_class/grade')->with($notification);
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
        }
    }

    public function getAttendance(Request $request){
        if($request->class_type == 1){
             $data = Attend::where("date",'=',Carbon::parse($request->attendanceDate)->format("Y-m-d"))
                             ->where("attendance_id", "=", $request->attendance_id)
                             ->get();
            return response()->json($data);
        }
    }
}
