<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trainingofficer;
use App\Rate;
use App\Groupapplication;
use App\Building;
use App\Floor;
use App\Scheduledprogram;
use App\Trainingclass;
use App\Day;
use Carbon\Carbon;
use App\Schedule;
use App\Scheduledetail;
use App\Holiday;
use App\Trainingroom;
use App\Attendance;
use App\Classdetail;
use App\Refund;
use App\Accountdetail;
use App\Nosessionday;
class EnrollmentController extends Controller
{
    public function viewEnrollment()
    {
        $officer = Trainingofficer::all()->where('active','=',1);
        $scheduledprogram = Scheduledprogram::all()->where('active','=',1);
        $rate = Rate::all()->where('active','=',1);
        $gapp = Groupapplication::all();
        $building = Building::all()->where('active','=',1);
        $first = $building->first();
        $floor = Floor::where('active','=',1)
                ->orderBy('building_id','ASC')->get();
        $class = array();
        $firsts = Floor::where('building_id','=',$first->id)->get();
        $firstsv2 = $firsts;
        $room = Trainingroom::where('floor_id','=',$firsts->first()->id)->get();
        $day = Day::all();
        $x=0;
        $y=0;
        $class = Trainingclass::where('status','=',1)->orWhere('status','=',0)->get();
        $tclass=array();
        $holiday = Holiday::all()->where('active','=',1);
        foreach ($class as $classes) {
                if(count($classes->groupapplicationdetail)==0)
                {
                    // start of date end
                    $check = true;
                    $checkdays = 0;
                    $dateEnd = Carbon::create();
                    $dateEnd = Carbon::parse($classes->scheduledprogram->dateStart);
                    $days = $classes->scheduledprogram->rate->duration/$classes->scheduledprogram->rate->classHour;
                    while ($check) {
                        $temp = Carbon::parse($dateEnd)->format('l');
                        $holidaycheck = false;
                        foreach($holiday as $holidays){
                            if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
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
                            foreach ($classes->schedule->scheduledetail as $details) {
                                if($temp == $details->day->dayName){
                                    $checkdays++;
                                }
                            }
                        }
                        if($days == 1)
                            $checkdays = 1;
                        if($checkdays == $days)
                        {
                            $check = false;
                        }
                        else{

                            $dateEnd = Carbon::parse($dateEnd)->addDays(1);
                        }
                    }
                //end of date end 
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
                    'id' => $classes->scheduledprogram->id,
                    'class_name' =>$classes->class_name,
                    'course_name' => $classes->scheduledprogram->rate->program->programName . ' (' . $classes->scheduledprogram->rate->duration . ' Hours) ',
                    'dateStart' =>Carbon::parse($classes->scheduledprogram->dateStart)->format("F d, Y"),
                    'dateEnd' => Carbon::parse($dateEnd)->format("F d, Y"),
                    'total' => count($classes->classdetail->where('status','=',2)) + count($classes->classdetail->where('status','=',3)),
                    'min_student'=>$classes->scheduledprogram->rate->min_students,
                    // 'officer' => $classes->scheduledprogram->trainingofficer->firstName . ' ' . $classes->scheduledprogram->trainingofficer->middleName . ' ' . $classes->scheduledprogram->trainingofficer->lastName,
                    'sched' => $schedules,
                    'status' =>$classes->status,
                    'counter'=>count($classes->schedule->scheduledetail),
                ];
                $x++;
            }
        }
        $z=0;
        return view('/admin/manage_enrollment/enrollment',compact('z','room','class','tclass','day','building','firsts','officer','rate','firstsv2'));
    }
    public function setEnrollment(Request $request)
    {
        $tclass = Trainingclass::find($request->id);
        $tclass->status = 1;
        $tclass->save();
        return redirect('/manage_enrollment');
    }
    public function insertEnrollment(Request $request){
        //validation
        $validdate = true;
        $message = "";
        $tofficer = Trainingofficer::find($request->officer_id);
        $checkconflict = false;
        $holiday = Holiday::all()->where('active','=',1);
        foreach($tofficer->scheduledprogram as $classes)
        {
            if($classes->trainingclass->status == 1 || $classes->trainingclass->status == 2 || $classes->trainingclass->status == 3)
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
                        if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
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
                        foreach ($classes->trainingclass->schedule->scheduledetail as $details) {
                            if($temp == $details->day->dayName){
                                $checkdays++;
                            }
                        }
                    }
                    if($days == 1)
                    {
                        $checkdays = 1;
                    }
                    if(Carbon::parse($request->dateStart)->eq($dateEnd)){
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
        $checkholiday = false;
        foreach($holiday as $holidays)
        {
            if(Carbon::parse($request->dateStart)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)))
            {
                $checkholiday = true;
            }
        }
        if($checkholiday)
        {
            $validdate = false;
            $message.= "Cannot start training session on holidays.";
        }
        else
        {
            $check = Nosessionday::where('date',Carbon::parse($request->dateStart)->format('Y-m-d'))->get();
            if(count($check)>0)
            {
                $validdate = false;
                $message.= "Cannot start session in this date";
            }
            else
            {
                if($checkconflict)
                {
                    $validdate = false;
                    $message.= "Conflict of schedule.";
                }
            }
        }
        if(count($request->start)!=0){
            if($request->start>$request->end)
            {
                $validdate = false;
                $message.=" Invalid date range.";
            }
            if(Carbon::parse($request->morning)->gte(Carbon::parse($request->afternoon)))
            {
                $validdate = false;
                $message.=" Invalid time.";
            }
        }
        else{
            for($i=0; $i<count($request->day)-1; $i++){
                for($a = $i+1; $a<count($request->day); $a++){
                    if($request->day[$i] == $request->day[$a]){
                        $validdate = false;
                        $message.=" Repeating day is not allowed.";
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
                    $message.=" Invalid Time.";
                    break;
                }
            }
        }
        $checkdatestart = false;
        if(count($request->day)>0)
        {
            foreach($request->day as $days)
            {
                echo Carbon::parse("2018-01-".$days)->format("l") .' '. Carbon::parse($request->dateStart)->format("l") .'<br>';
                if(Carbon::parse("2018-01-".$days)->format("l") == Carbon::parse($request->dateStart)->format("l"))
                {
                    $checkdatestart == true;
                }
            }   
        }
        if($checkdatestart)
        {
            $validdate = false;
            $message.=" Invalid Starting Schedule.";
        }
        if($validdate){
            $message = "New schedule is successfully added";
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'success'
                );
            //insert 
            $sprog = new Scheduledprogram;
            $sprog->dateStart = $request->dateStart;
            $sprog->rate_id = $request->rate_id;
            $sprog->trainingofficer_id = $request->officer_id;
            $sprog->save();
            $sprog= Scheduledprogram::all();
            $lastrate = $sprog->last();
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
                $day = $request->day;
                $morning = $request->morning;
                $afternoon = $request->afternoon;
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
                            $afternoon[$i] = $afternoon[$a];
                            $afternoon[$a] = $tempa;
                            $breaktime[$i] = $breaktime[$a];
                            $breaktime[$a] = $tempb;

                        }
                    }
                }
                for($i=0; $i<count($request->day); $i++){
                    $sdetail = new Scheduledetail;
                    $sdetail->day_id = $day[$i];
                    $sdetail->start = $morning[$i];
                    $sdetail->end = $afternoon[$i];
                    $sdetail->breaktime = $breaktime[$i];
                    $sdetail->schedule_id = $schedule->id;
                    $sdetail->save();
                }
            }

            $class = new Trainingclass;
            $class->class_name = 'Class ' . $lastrate->id;
            $class->scheduledprogram_id = $lastrate->id;
            $class->trainingroom_id = $request->room_id;
            $class->status = 0;
            $class->schedule_id = $schedule->id;
            $class->save();
            $class = Trainingclass::all();
            $class = $class->last();

            $attendance = new Attendance;
            $attendance->trainingclass_id = $class->id;
            $attendance->save();
            if(count($request->calendar)!=0)
            {
                return redirect('/calendar')->with($notification);
            }
            else
            {
                return redirect('/manage_enrollment')->with($notification);
            }
        }
        else{
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            if(count($request->calendar)!=0)
            {
                return redirect('/calendar')->with($notification);
            }
            else
            {
                return redirect('/manage_enrollment')->with($notification);
            }
        }
    }

    public function updateDateStart(Request $request){
        //validation
        $validdate = true;
        $message = "";
        $tofficer = Trainingofficer::find($request->officer_id);
        $checkconflict = false;
        $holiday = Holiday::all()->where('active','=',1);
        foreach($tofficer->scheduledprogram as $classes)
        {
            if($classes->trainingclass->status == 1 || $classes->trainingclass->status == 2 || $classes->trainingclass->status == 3)
            {
                if($classes->trainingclass->id != $request->trainingclass_id)
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
                            if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
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
                        if($days == 1)
                        {
                            $checkdays = 1;
                        }
                        if(Carbon::parse($request->dateStart)->eq($dateEnd)){
                            $checkconflict = true;
                        }
                        echo Carbon::parse($request->dateStart). '  ' . $dateEnd . '<br>';
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
        $checkholiday = false;
        foreach($holiday as $holidays)
        {
            if(Carbon::parse($request->dateStart)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)))
            {
                $checkholiday = true;
            }
        }
        if($checkholiday)
        {
            $validdate = false;
            $message.= "Cannot start training session on holidays.";
        }
        else
        {
            $check = Nosessionday::where('date',Carbon::parse($request->dateStart)->format('Y-m-d'))->get();
            if(count($check)>0)
            {
                $validdate = false;
                $message.= "Cannot start session in this date";
            }
            else
            {
                if($checkconflict)
                {
                    $validdate = false;
                    $message.= "Conflict of schedule.";
                }
            }
        }

        $sprog = Scheduledprogram::find($request->trainingclass_id);
        $checkdatestart = false;
        foreach($sprog->trainingclass->schedule->scheduledetail as $days)
        {
            if(Carbon::parse("2018-01-".$days->day_id)->format("l") == Carbon::parse($request->datestart)->format("l"))
                {
                    $checkdatestart == true;
                }
        }
        if($checkdatestart)
        {
            $validdate = false;
            $message.=" Invalid Starting Schedule.";
        }
        if($validdate){
            $message = "Schedule is successfully updated";
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'success'
                );
            //insert 
            $sprog->dateStart = $request->dateStart;
            $sprog->save();
            if(count($request->calendar)!=0)
            {
                return redirect('/calendar')->with($notification);
            }
            else
            {
                return redirect('/manage_enrollment')->with($notification);
            }
        }
        else{
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            if(count($request->calendar)!=0)
            {
                return redirect('/calendar')->with($notification);
            }
            else
            {
                return redirect('/manage_enrollment')->with($notification);
            }
        }
    }

    public function updateEnrollment(Request $request){
        //validation
        $validdate = true;
        $message = "";
        $tofficer = Trainingofficer::find($request->officer_id);
        $checkconflict = false;
        $holiday = Holiday::all()->where('active','=',1);
        foreach($tofficer->scheduledprogram as $classes)
        {
            if($classes->trainingclass->status == 1 || $classes->trainingclass->status == 2 || $classes->trainingclass->status == 3)
            {
                if($classes->trainingclass->id != $request->trainingclass_id)
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
                            if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
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
                            foreach ($classes->trainingclass->schedule->scheduledetail as $details) {
                                if($temp == $details->day->dayName){
                                    $checkdays++;
                                }
                            }
                        }
                        if($days == 1)
                        {
                            $checkdays = 1;
                        }
                        if(Carbon::parse($request->dateStart)->eq($dateEnd)){
                            $checkconflict = true;
                        }
                        echo Carbon::parse($request->dateStart). '  ' . $dateEnd . '<br>';
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
        $checkholiday = false;
        foreach($holiday as $holidays)
        {
            if(Carbon::parse($request->dateStart)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd)))
            {
                $checkholiday = true;
            }
        }
        if($checkholiday)
        {
            $validdate = false;
            $message.= "Cannot start training session on holidays.";
        }
        else
        {
            $check = Nosessionday::where('date',Carbon::parse($request->dateStart)->format('Y-m-d'))->get();
            if(count($check)>0)
            {
                $validdate = false;
                $message.= "Cannot start session in this date";
            }
            else
            {
                if($checkconflict)
                {
                    $validdate = false;
                    $message.= "Conflict of schedule.";
                }
            }
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
        $checkdatestart = false;
        if(count($request->start)==0){
            foreach($request->day as $days)
            {
                if(Carbon::parse("2018-01-".$days)->format("l") == Carbon::parse($request->dateStart)->format("l"))
                    {
                        $checkdatestart == true;
                    }
            }
        }
        if($checkdatestart)
        {
            $validdate = false;
            $message.=" Invalid Starting Schedule.";
        }
        if($validdate){
            $message = "Schedule is successfully updated";
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'success'
                );
            //insert 
            $sprog = Scheduledprogram::find($request->trainingclass_id);
            $sprog->dateStart = $request->dateStart;
            $sprog->rate_id = $request->rate_id;
            $sprog->trainingofficer_id = $request->officer_id;
            $sprog->save();
            $schedule = Schedule::find($sprog->trainingclass->schedule->id);
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
                    $sdetail->end = $request->afternoon;
                    $sdetail->breaktime = $request->breaktime;
                    $sdetail->schedule_id = $schedule->id;
                    $sdetail->save();
                }
            }
            else{
                $day = $request->day;
                $morning = $request->morning;
                $afternoon = $request->afternoon;
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
                            $afternoon[$i] = $afternoon[$a];
                            $afternoon[$a] = $tempa;
                            $breaktime[$i] = $breaktime[$a];
                            $breaktime[$a] = $tempb;

                        }
                    }
                }
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

            $class = Trainingclass::find($request->trainingclass_id);
            $class->trainingroom_id = $request->room_id;
            $class->save();
            if(count($request->calendar)!=0)
            {
                return redirect('/calendar')->with($notification);
            }
            else
            {
                return redirect('/manage_enrollment')->with($notification);
            }
        }
        else{
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            if(count($request->calendar)!=0)
            {
                return redirect('/calendar')->with($notification);
            }
            else
            {
                return redirect('/manage_enrollment')->with($notification);
            }
        }
    }

    public function viewEnrollee(Request $request){
    	$sprog = Scheduledprogram::find($request->sprog_id);
        $detail = $sprog->trainingclass->classdetail;
        return view('admin/manage_enrollment/viewenrollee',compact('officer','sprog','detail'));
    }

    public function viewCalendar(){
        $officer = Trainingofficer::all()->where('active','=',1);
        $scheduledprogram = Scheduledprogram::all()->where('active','=',1);
        $rate = Rate::all()->where('active','=',1);
        $gapp = Groupapplication::all();
        $building = Building::all()->where('active','=',1);
        $first = $building->first();
        $floor = Floor::where('active','=',1)
                ->orderBy('building_id','ASC')->get();
        $class = array();
        $firsts = Floor::where('building_id','=',$first->id)->get();
        $firstsv2 = $firsts;
        $room = Trainingroom::where('floor_id','=',$firsts->first()->id)->get();
        $day = Day::all();
        $x=0;
        $y=0;
        $class = Trainingclass::where('status','=',1)->orWhere('status','=',0)->get();
        $tclass=array();
        $holiday = Holiday::all()->where('active','=',1);
        foreach ($class as $classes) {
                if(count($classes->groupapplicationdetail)==0)
                {
                    // start of date end
                    $check = true;
                    $checkdays = 0;
                    $dateEnd = Carbon::create();
                    $dateEnd = Carbon::parse($classes->scheduledprogram->dateStart);
                    $days = $classes->scheduledprogram->rate->duration/$classes->scheduledprogram->rate->classHour;
                    while ($check) {
                        $temp = Carbon::parse($dateEnd)->format('l');
                        $holidaycheck = false;
                        foreach($holiday as $holidays){
                            if(Carbon::parse($dateEnd)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
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
                            foreach ($classes->schedule->scheduledetail as $details) {
                                if($temp == $details->day->dayName){
                                    $checkdays++;
                                }
                            }
                        }
                        if($days == 1)
                            $checkdays = 1;
                        if($checkdays == $days)
                        {
                            $check = false;
                        }
                        else{

                            $dateEnd = Carbon::parse($dateEnd)->addDays(1);
                        }
                    }
                //end of date end 
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
                    'id' => $classes->scheduledprogram->id,
                    'class_name' =>$classes->class_name,
                    'course_name' => $classes->scheduledprogram->rate->program->programName . ' (' . $classes->scheduledprogram->rate->duration . ' Hours) ',
                    'dateStart' =>Carbon::parse($classes->scheduledprogram->dateStart)->format("F d, Y"),
                    'dateEnd' => Carbon::parse($dateEnd)->format("F d, Y"),
                    'total' => count($classes->classdetail->where('status','=',2)) + count($classes->classdetail->where('status','=',3)),
                    'min_student'=>$classes->scheduledprogram->rate->min_students,
                    // 'officer' => $classes->scheduledprogram->trainingofficer->firstName . ' ' . $classes->scheduledprogram->trainingofficer->middleName . ' ' . $classes->scheduledprogram->trainingofficer->lastName,
                    'sched' => $schedules,
                    'status' =>$classes->status,
                    'counter'=>count($classes->schedule->scheduledetail),
                ];
                $x++;
            }
        }
        $z=0;
        return view('admin/manage_enrollment/calendar',compact('z','holiday','building','tclass','day','firsts','class','officer','rate','floor','room'));
    }

    public function cancelEnrollment(Request $request){

        $schedule = Scheduledprogram::find($request->tclass_id);
        $schedule->active = 5;
        $schedule->save();
        $tclass = trainingclass::find($request->tclass_id);
        $tclass->status = 5;
        $tclass->save();
        $classdetail = Classdetail::where('trainingclass_id','=',$request->tclass_id)->get();
        foreach($classdetail as $details)
        {
            if($details->status != 1)
            {
                $refund = new Refund;
                $refund->enrollee_id = $details->enrollee_id;
                $refund->trainingclass_id = $request->tclass_id;
                $amount = 0;
                if($details->status = 2)
                {
                    $amount = $details->trainingclass->scheduledprogram->rate->price/2;
                }
                else if($details->status = 3){
                    $amount = $details->trainingclass->scheduledprogram->rate->price;
                }
                $refund->amount = $amount;
                $refund->date = Carbon::today()->format('Y-m-d');
                $refund->save();
            }
            $accountdetail = Accountdetail::where('account_id','=',$details->enrollee->account->id)->where('scheduledprogram_id','=',$details->trainingclass_id)->get();
            foreach($accountdetail as $accountdetail)
            {
                $accountD = Accountdetail::find($accountdetail->id);
                $accountD->delete();
            }
            $classD = Classdetail::find($details->id);
            $classD->delete();
        }
        return redirect('/manage_enrollment');
    }

    public function fillSchedule(Request $request){
        
        $tclass = Trainingclass::find($request->tclasses_id);
        $data = array();
        $data = [
            "rate_id" => $tclass->scheduledprogram->rate_id,
            "trainingofficer_id" => $tclass->scheduledprogram->trainingofficer_id,
            "dateStart" => $tclass->scheduledprogram->dateStart,
            "building" => $tclass->trainingroom->building_id,
            "floor" => $tclass->trainingroom->floor_id,
            "room" => $tclass->trainingroom->room_no
        ];
        // return view('/admin/manage_enrollment/enrollment',compact('room','tclass','day','building','firsts','officer','rate','firstsv2'));
    }

    public function nosession(Request $request){
        $check = Nosessionday::where('date',$request->date)->get();
        $holiday = Holiday::all()->where('active','=',1);
        $holidaycheck = false;
        foreach($holiday as $holidays){
            if(Carbon::parse($request->date)->between(Carbon::parse($holidays->dateStart), Carbon::parse($holidays->dateEnd))){
            $holidaycheck = true;
            }
        }
        if(!$holidaycheck)
        {
            if(count($check)>0)
            {
                $message = "This date already exist";
                $notification = array(
                        'message' => $message, 
                        'alert-type' => 'warning'
                    );
                return redirect()->back()->with($notification);
            }
            else
            {
                $session = new Nosessionday;
                $session->date = $request->date;
                $session->description = $request->description;
                $session->save();
                $message = "New no session day has been added";
                $notification = array(
                        'message' => $message, 
                        'alert-type' => 'success'
                    );
                return redirect()->back()->with($notification);
            }
        }
        else
        {
            $message = "Date is already in Holidays";
            $notification = array(
                    'message' => $message, 
                    'alert-type' => 'warning'
                );
            return redirect()->back()->with($notification);
        }
        
    }
}
