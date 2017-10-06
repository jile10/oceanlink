<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
use App\Day;
use App\Program;
use Carbon\Carbon;
use App\Scheduledetail;
class ScheduleController extends Controller
{
    public function viewSchedule(){
    	$schedule = Schedule::all()->where('active','=',1);
    	$program = Program::all()->where('active','=',1);
    	$day = Day::all();
    	$check = false;
    	return view('admin/maintenance/schedule',compact('schedule','day','program','check'));
    }

    public function insertSchedule(Request $request){  	
    	$schedule = new Schedule;
    	$schedule->program_id = $request->program_id;
    	$schedule->start = Carbon::parse($request->start)->format('G:i:s');
    	$schedule->end = Carbon::parse($request->end)->format('G:i:s');
    	$schedule->save();

    	$schedules = Schedule::all()->where('active','=',1);
    	$last = $schedules->last();
    	foreach ((array)$request->check_id as $check_id) {
    		$sdetail = new Scheduledetail;
    		$sdetail->schedule_id = $last->id;
    		$sdetail->day_id = $check_id;
    		$sdetail->save();
    	}

    	return redirect('maintenance/schedule');
    }

    public function updateSchedule(Request $request){  	
    	$schedule = Schedule::find($request->id);
    	$schedule->program_id = $request->program_id;
    	$schedule->start = Carbon::parse($request->start)->format('G:i:s');
    	$schedule->end = Carbon::parse($request->end)->format('G:i:s');
    	$schedule->save();

    	$deleteRows = Scheduledetail::where('schedule_id','=',$request->id)->delete();
    	$schedules = Schedule::all()->where('active','=',1);
    	foreach ((array)$request->check_id as $check_id) {
    		$sdetail = new Scheduledetail;
    		$sdetail->schedule_id = $request->id;
    		$sdetail->day_id = $check_id;
    		$sdetail->save();
    	}
    	return redirect('maintenance/schedule');
    }

     public function deleteSchedule(Request $request){  	
    	$schedule = Schedule::find($request->id);
    	$schedule->active = 0;
    	$schedule->save();
    	return redirect('maintenance/schedule');
    }
}
