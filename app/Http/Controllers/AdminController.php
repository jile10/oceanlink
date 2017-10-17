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
            $checkdays = 1;
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
                $dateEnd = Carbon::parse($dateEnd)->addDays(1);
            }
        	//end of date end
            $x++;
            $tclass = Trainingclass::find($classes->id);
            $end = Carbon::parse($dateEnd);
            //end class
            if(Carbon::today()->gte($end))
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
                if($count($trainingclasses->groupapplicationdetail->where('status','!=',1)))
                {
                    $enrolledStudents += count($trainingclasses->groupclassdetail);
                }
            }
        }

        //ongoing courses
        $ongoingCourses = 0;
        $trainingClass = count(Trainingclass::where('status','=',2)->get());

        //training officers
        $trainingOfficers = count(Trainingofficer::where('active','=',1)->get());

       return view('admin.home',compact('enrolledStudents','ongoingCourses','trainingOfficers'));
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
