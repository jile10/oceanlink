<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use Carbon\Carbon;
class HolidayController extends Controller
{
    public function viewHoliday(){
    	$holiday = Holiday::all()->where('active','=',1);
    	return view("/admin/maintenance/holiday",compact('holiday'));
    }
    public function insertHoliday(Request $request){
    	$check = true;
    	$holiday = Holiday::all();
    	foreach ($holiday as $holidays) {
    		if(strtolower($holidays->holidayName) == strtolower($request->holidayName))
    		{
    			$check=false;
    		}
    		if($holidays->dateStart == $request->dateStart && $holidays->dateEnd == $request->dateEnd){
    			$check= false;
    		}
    	}
    	if($check)
    	{
	    	$holiday = new Holiday;
	    	$holiday->holidayName = $request->holidayName;
	    	$holiday->dateStart = Carbon::parse($request->dateStart)->format("Y-m-d");
	    	$holiday->dateEnd = Carbon::parse($request->dateEnd)->format("Y-m-d");
	    	$holiday->active = 1;
	    	$holiday->save();

	    	$notification = array(
	                'message' => 'New Holiday has been successfully added', 
	                'alert-type' => 'success'
	            );
    	}
    	else
    	{
    		$notification = array(
	                'message' => 'Duplication of data is not allowed', 
	                'alert-type' => 'warning'
	            );
    	}
        return redirect('/maintenance/holiday')->with($notification);
    }

    public function updateHoliday(Request $request){
    	$check = true;
    	$holiday = Holiday::all();
    	foreach ($holiday as $holidays) {
            if($request->id != $holidays->id)
            {
        		if(strtolower($holidays->holidayName) == strtolower($request->holidayName))
        		{
        			$check=false;
        		}
        		if($holidays->dateStart == $request->dateStart && $holidays->dateEnd == $request->dateEnd){
        			$check= false;
        		}
            }
    	}
    	if($check)
    	{
	    	$holiday = Holiday::find($request->id);
	    	$holiday->holidayName = $request->holidayName;
	    	$holiday->dateStart = Carbon::parse($request->dateStart)->format("Y-m-d");
	    	$holiday->dateEnd = Carbon::parse($request->dateEnd)->format("Y-m-d");
	    	$holiday->active = 1;
	    	$holiday->save();
	    	$notification = array(
                'message' => 'Holiday has been successfully updated', 
                'alert-type' => 'success'
            );
    	}
    	else
    	{
    		$notification = array(
	                'message' => 'Duplication of data is not allowed', 
	                'alert-type' => 'warning'
	            );
    	}
        return redirect('/maintenance/holiday')->with($notification);
    }

    public function deleteHoliday(Request $request){
    	$holiday = Holiday::find($request->id);
    	$holiday->active = 0;
    	$holiday->save();

    	$notification = array(
            'message' => 'Holiday has been successfully deleted', 
            'alert-type' => 'success'
        );
        
        return redirect('/maintenance/holiday')->with($notification);
    }
}
