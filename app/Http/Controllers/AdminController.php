<?php

namespace App\Http\Controllers;
use App\Scheduledprogram;
use Illuminate\Http\Request;
use App\Civilstatus;
use App\Trainingclass;
use Carbon\Carbon;
use App\Certificate;
use App\Groupclassdetail;
use App\Holiday;
use App\Classdetail;
use App\Nosessionday;
use App\Trainingofficer;
use App\Accountdetail;
use Image;
use Auth;
class AdminController extends Controller
{
	public function home(){
       $holiday = Holiday::all();
        //update holiday
        foreach ($holiday as $holidays ) {
            $updateHoliday = $holidays;
            if(Carbon::parse($updateHoliday->dateStart)->format('Y') != Carbon::today()->format('Y')){
                $updateHoliday->dateStart = Carbon::parse($updateHoliday->dateStart)->addYears(1)->format('Y-m-d');
                $updateHoliday->dateEnd = Carbon::parse($updateHoliday->dateEnd)->addYears(1)->format('Y-m-d');
                $updateHoliday->save();
            }
        } 
		$trainingclass = Trainingclass::all()->where('status','=',1);
		foreach($trainingclass as $tclasses){
			$tclass = Trainingclass::find($tclasses->id);
			if(Carbon::today()->gte(Carbon::parse($tclasses->scheduledprogram->dateStart))){
				$tclass->status = 2;
				$tclass->save();
                if(count($tclasses->groupclassdetail)==0){
                    foreach($tclasses->classdetail->where('status',1) as $details){
                        $account = $details->enrollee->account;
                        $accountdetail = $account->accountdetail->where('scheduledprogram','=',$details->trainingclass->scheduledprogram->id);
                        $accountdetail->delete();
                        $cdetail = $details;
                        $cdetail->delete();
                    }
                }

                if(count($tclasses->groupclassdetail)>0)
                {
                    foreach($tclasses->groupclassdetail as $details){
                        $certificate = Certificate::all();
                        $a = count($certificate)+1;
                        $certificate = new Certificate;
                        $certificate->certificate_no = "OL-". $tclasses->scheduledprogram->rate->program->programCode . '-' . $a .'-' .Carbon::now()->format('Y');
                        $certificate->date_issued = Carbon::now()->format('Y-m-d');
                        $certificate->save();
                        $certificate = Certificate::all();
                        
                        $groupclassdetail = Groupclassdetail::find($details->id);
                        $groupclassdetail->certificate_id = $a;
                        $groupclassdetail->save();
                    }
                }
                else
                {                    
                        foreach($tclasses->classdetail->where('status','!=',1) as $details){
                            $certificate = Certificate::all();
                            $a = count($certificate)+1;
                            $certificate = new Certificate;
                            $certificate->certificate_no = "OL-". $tclasses->scheduledprogram->rate->program->programCode . '-' . $a .'-' .Carbon::now()->format('Y');
                            $certificate->date_issued = Carbon::now()->format('Y-m-d');
                            $certificate->save();
                            $certificate = Certificate::all();
                            
                            $groupclassdetail = Classdetail::find($details->id);
                            $groupclassdetail->certificate_id = $a;
                            $groupclassdetail->save();
                        }
                }
			}
		}
		$x=0;
        $y=0;
        $class = Trainingclass::where('status','=',2)->get();
        $tclass=array();
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
        foreach ($class as $classes) {
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
        	//end of date end
            $x++;
            $tclass = Trainingclass::find($classes->id);
            $end = Carbon::parse($dateEnd);
            //end class
            if(Carbon::today()->gt($end))
            {
                $tclass->status = 4;
                $tclass->save();
            }
        }
		
        //Dashboard the real deal
        //EnrolledSTudents
        $enrolledStudents = 0;
        $trainingclass = Trainingclass::where('status','=',1)->orWhere('status','=',2)->get();
        foreach($trainingclass as $trainingclasses){
            if(count($trainingclasses->classdetail)>0)
            {
                $enrolledStudents += count($trainingclasses->classdetail->where('status','!=',1));
            }
            else{
                if(count($trainingclasses->groupapplicationdetail)>0){
                    if(count($trainingclasses->groupapplicationdetail->where('status','!=',1))>0)
                    {
                        $enrolledStudents += count($trainingclasses->groupclassdetail);
                    }
                }
            }
        }

        //ongoing courses
        $ongoingCourses = 0;
        $trainingClass = count(Trainingclass::where('status','=',2)->get());

        //training officers
        $trainingOfficers = count(Trainingofficer::where('active','=',1)->get());

        $x=0;
        $y=0;
        $class = Trainingclass::where('status','=',1)->get();
        $tclass=array();
        $holiday = Holiday::all()->where('active','=',1);
        $sessionday = Nosessionday::all();
        foreach ($class as $classes) {
                $dateEnd = Carbon::create();
                $dateEnd = Carbon::parse($classes->scheduledprogram->dateStart);
                $dayschedule = array();
                if(count($classes->groupapplicationdetail)==0)
                {
                    // start of date end
                    $dayschedule = "";
                    $check = true;
                    $checkdays = 0;
                    $days = $classes->scheduledprogram->rate->duration/$classes->scheduledprogram->rate->classHour;
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
                                    $dayschedule[$checkdays] = [
                                        "date" => $dateEnd,
                                        "time" => Carbon::parse($details->start)->format("g:i A") . '-' . Carbon::parse($details->end)->format("g:i A"),
                                    ];
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
                        $scounter = $details->day->id;
                        if($scounter != 0)
                        {
                            if($details->day->id - $scounter != 1){
                                $scheck = false;
                                break;
                            }
                        }
                    }
                    if($scheck){
                        if(count(Scheduledetail::where('schedule_id','=',$classes->schedule->id)->get())==1){
                            $sched = Scheduledetail::where('schedule_id','=',$classes->schedule->id);
                            $startsched = $sched->first();
                            $startsched = Carbon::parse($startsched->day->dayName)->format("D");
                            $schedules = $startsched;
                            $time = $sched->first();
                            $schedules .= ' &ensp;' . Carbon::parse($time->start)->format("g:i A") . '-' . Carbon::parse($time->end)->format("g:i A");
                        }
                        else
                        {
                            $dump = array();
                            $x=0;
                            $sched = Scheduledetail::where('schedule_id','=',$classes->schedule->id)->get();
                            $checkforsched = true;
                            for($i=0; $i<count($sched)-1;$i++)
                            {   
                                for($a=$i+1;$a<count($sched);$a++)
                                {
                                    if($sched[$i]->start != $sched[$a]->start)
                                    {
                                        $checkforsched = false;
                                    }
                                }
                            }
                            if($checkforsched == false)
                            {
                                $schedules = array();
                                $counters = 0;
                                for($i=0; $i<count($sched)-1;$i++)
                                {   
                                    $schek = true;
                                    for($b = 0;$b<count($dump);$b++)
                                    {
                                        if($sched[$i]->day_id == $dump[$b])
                                        {
                                            $schek = false;
                                        }
                                    }
                                    for($b = 0;$b<count($dump);$b++)
                                    {
                                        if($sched[$i]->day_id == $dump[$b])
                                        {
                                            $schek = false;
                                        }
                                    }
                                    $schedfirst=Carbon::parse($sched[$i]->day->dayName)->format("D");
                                    for($a=$i+1;$a<count($sched);$a++)
                                    {
                                        if($schek)
                                        {
                                            if($sched[$i]->start == $sched[$a]->start)
                                            {
                                                $schedfirst .= "/" . Carbon::parse($sched[$a]->day->dayName)->format("D");
                                                $dump[$x] = $sched[$a]->day_id;
                                                $x++;
                                            }
                                        }
                                    }
                                    if($schek)
                                    {
                                        $schedfirst .= " ". Carbon::parse($sched[$i]->start)->format("g:i A") .' - ' . Carbon::parse($sched[$i]->end)->format("g:i A");
                                        $schedules[$counters] = [
                                            'scheds' => $schedfirst,
                                        ];
                                        $counters++;
                                    }
                                }
                            }
                            else
                            {
                                $startsched = $sched->first();
                                $startsched = Carbon::parse($startsched->day->dayName)->format("D");
                                $endsched = $sched->last();
                                $endsched = Carbon::parse($endsched->day->dayName)->format("D");
                                $schedules = $startsched . '-' . $endsched;
                                $time = $sched->first();
                                $schedules .= ' &ensp;' . Carbon::parse($time->start)->format("g:i A") . '-' . Carbon::parse($time->end)->format("g:i A");
                            }
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
                    'id' => $classes->id,
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
                    'dayschedule'=>$dayschedule,
                ];
                $x++;
            }
        }
        $barChart = array();
        for($a = 1; $a<13; $a++)
        {   
            $y=0;
            $y = count(Classdetail::whereMonth('updated_at','=',$a)->whereYear('updated_at','=',Carbon::today()->format('Y'))->where('status','!=',1)->get());
            $y += count(Groupclassdetail::whereMonth('updated_at','=',$a)->whereYear('updated_at','=',Carbon::today()->format('Y'))->get());
            $barChart[$a-1] = [
                "month"=>Carbon::parse('2017-'.$a.'-1')->format('M'),
                "count"=>$y,
            ];
        }

       return view('admin.home',compact('barChart','tclass','sessionday','holiday','enrolledStudents','ongoingCourses','trainingOfficers'));
	}

	public function gapplication(){
		$sprogram = Scheduledprogram::all()->where('active','=',1);
		return view('admin.manage_application.gapplication',compact('sprogram'));
	}

    public function viewAccount(){
        return view('admin.accountsetting');
    }

    public function updateImage(Request $request){
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save( public_path('display_image/'.$filename));

            $employee = Auth::user()->employee;
            $employee->image = $filename;
            $employee->save();

            return redirect('/admin/accountsetting');
        }
    }
}
