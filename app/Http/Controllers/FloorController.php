<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Floor;
use App\Building;
class FloorController extends Controller
{
    public function viewFloor(){
    	$floor = Floor::all()->where('active','=',1);
    	$building = Building::all()->where('active','=',1);
    	return view('admin.maintenance.floor',compact('floor','building'));
    }

    public function insertFloor(Request $request){
        $floors = Floor::all();
        $check = true;
        $messages = "";
        foreach($floors as $floors){
            if(strtolower(trim($floors->floorName)).$floors->building_id ==strtolower(trim($request->floorName)).$request->building_id)
            {
                $check = false;
                $messages .= "Duplication of floor is not allowed. ";
            }
        }

        if($check)
        {
        	$floor = new Floor;
        	$floor->floorName = $request->floorName;
        	$floor->building_id = $request->building_id;
        	$floor->save();

            $notification = array(
                'message' => 'New floor has been successfully added', 
                'alert-type' => 'success'
            );

        	return redirect('maintenance/floor')->with($notification);
        }
        else
        {
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'warning'
            );

            return redirect()->back()->with($notification);
        }
    }

    public function updateFloor(Request $request){
        $floors = Floor::all();
        $check = true;
        $messages = "";
        foreach($floors as $floors){
            if(strtolower(trim($floors->floorName)).$floors->id.$floors->building_id != strtolower(trim($request->floorName)).$request->id.$request->building_id)
            {
                if(strtolower(trim($floors->floorName)).$floors->building_id == strtolower(trim($request->floorName)).$request->building_id)
                {
                    $check = false;
                    $messages .= "Duplication of floor is not allowed. ";
                }
            }
        }
        if($check){
            $floor = Floor::find($request->id);
            $floor->floorName = $request->floorName;
            $floor->building_id = $request->building_id;
            $floor->save();

            $notification = array(
                'message' => 'Floor has been successfully updated', 
                'alert-type' => 'success'
            );
            return redirect('maintenance/floor')->with($notification);
        }
        else
        {
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
    	
        
    }

    public function deleteFloor(Request $request){
    	$floor = Floor::find($request->id);
    	$floor->active = 0;
    	$floor->save();

        $notification = array(
            'message' => 'Floor has been successfully remove', 
            'alert-type' => 'success'
        );
        
    	return redirect('maintenance/floor')->with($notification);
    }

    public function viewArchive(){
        $floor = Floor::all()->where('active','=',0);
        $building = Building::all()->where('active','=',1);
        return view('admin.maintenance.archivefloor',compact('floor','building'));
    }

    public function activateFloor(Request $request){
        $floor = Floor::find($request->id);
        $floor->active = 1;
        $floor->save();

        $notification = array(
            'message' => 'Floor has been successfully activated', 
            'alert-type' => 'success'
        );
        
        return redirect('maintenance/floor')->with($notification);
    }

}
