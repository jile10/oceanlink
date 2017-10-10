<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unit;
use App\Program;
use App\Rate;
use App\Day;
use App\Programtype;
use App\Schedule;
use App\Scheduledetail;
use Carbon\Carbon;
class RateController extends Controller
{
    public function viewRate(){
        $rate = Rate::all()->where('active','=',1);
    	$program = Program::all()->where('active','=',1);
        $type = Programtype::all()->where('active','=',1);
        $first = $program->where('programtype_id','=',$type->first()->id);
    	return view('/admin/maintenance/rate',compact('first','rate','type'));

    }

    public function insertRate(Request $request){
        $compare = true;
        $check = true;
        $messages = "";
        $rates = Rate::all();
        foreach($rates as $rates)
        {
            if($rates->program_id.$rates->duration == $request->program_id.$request->duration)
            {
                $check = false;
                $messages .= "Duplication of data is not allowed.";
            }
        }
        if($request->class_hours<=0)
        {
            $check = false;
            $messages .= "Invalid class hours input.";
        }

        if($request->duration<$request->class_hours)
        {
            $check = false;
            $messages .= "Total no. of Hours must be greater than class hours.";
        }
        if($request->price<=0)
        {
            $check = false;
            $messages .= "Invalid price input.";
        }
        if($request->min_students > $request->max_students)
        {
            $check = false;
            $messages .= "Maximum no. of students must be greater than minimum no. of students";
        }
        if($check)
        {   
            $rate = new Rate;
            $rate->program_id = $request->program_id;
            $rate->duration =  $request->duration;
            $rate->classHour = $request->class_hours;
            $rate->price =  str_replace(',','',$request->price);
            $rate->min_students = $request->min_students;
            $rate->max_students = $request->max_students;
            $rate->save();
            $notification = array(
                'message' => 'New course has been successfully added', 
                'alert-type' => 'success'
            );

            return redirect('/maintenance/rate')->with($notification);
        }
        else{
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }
        
    }

    public function updateRate(Request $request){
        $compare = true;
        $check = true;
        $messages = "";
        $rates = Rate::all();
        foreach($rates as $rates)
        {   if($rates->id != $request->id)
            {
                if($rates->program_id.$rates->duration == $request->program_id.$request->duration)
                {
                    $check = false;
                    $messages .= "Duplication of data is not allowed.";
                }
            }
                
        }
        if($request->class_hours<=0)
        {
            $check = false;
            $messages .= "Invalid class hours input.";
        }
        if($request->duration<$request->class_hours)
        {
            $check = false;
            $messages .= "Total no. of Hours must be greater than class hours.";
        }
        if($request->price<=0)
        {
            $check = false;
            $messages .= "Invalid price input.";
        }
        if($request->min_students > $request->max_students)
        {
            $check = false;
            $messages .= "Maximum no. of students must be greater than minimum no. of students";
        }
        if($check)
        {   
            $rate = Rate::find($request->id);
            $rate->program_id = $request->program_id;
            $rate->duration =  $request->duration;
            $rate->classHour = $request->class_hours;
            $rate->price =  str_replace(',','',$request->price);
            $rate->min_students = $request->min_students;
            $rate->max_students = $request->max_students;
            $rate->save();
            $notification = array(
                'message' => 'Course has been successfully updated', 
                'alert-type' => 'success'
            );

            return redirect('/maintenance/rate')->with($notification);
        }
        else{
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }

    }

    public function deleteRate(Request $request){
        $rate = Rate::find($request->id);
        $rate->active = 0;
        $rate->save();

        $notification = array(
            'message' => 'Course has been successfully removed', 
            'alert-type' => 'success'
        );


        return redirect('/maintenance/rate')->with($notification);
    }

    public function viewArchive(){
        $rate = Rate::all()->where('active','=',0);
        return view('/admin/maintenance/archiverate',compact('rate'));

    }

    public function activateRate(Request $request){
        $rate = Rate::find($request->id);
        $rate->active = 1;
        $rate->save();

        $notification = array(
            'message' => 'Course has been successfully activated', 
            'alert-type' => 'success'
        );


        return redirect('/maintenance/rate')->with($notification);
    }

    public function ajaxType(Request $request){
        $data = Program::select('programName','id')
            ->where('programtype_id',$request->id)
            ->where('active',1)
            ->get();
        return response()->json($data);
    }
}
