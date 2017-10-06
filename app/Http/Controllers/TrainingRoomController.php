<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trainingroom;
use App\Building;
use App\Floor;
class TrainingRoomController extends Controller
{
	public function viewRoom(){
		$room = Trainingroom::all()->where('active','=',1);
		$building = Building::all()->where('active','=',1);
		$buildingfirst = $building->first();
		$floorfirst = Floor::where('building_id','=',$buildingfirst->id)->get();
		return view('/admin/maintenance/room',compact('room','building','floorfirst'));
	}

	public function createRoom(Request $request){
		$rooms = Trainingroom::all();
		$check = true;
		$messages = "";
		foreach($rooms as $rooms)
		{
			if($rooms->building_id.$rooms->floor_id.strtolower(trim($rooms->room_no)) == $request->building_id.$request->floor_id.strtolower(trim($request->room_no)))
			{
				$check = false;
				$messages .= "Duplication of room is not allowed";
			}
			if($request->capacity<=0){
				$check = false;
				$messages .= "Invalid capacity. ";
			}
		}
		if($check)
		{
			$room = new Trainingroom;
			$room->room_no = $request->room_no;
			$room->capacity = $request->capacity;
			$room->building_id = $request->building_id;
			$room->floor_id = $request->floor_id;
			$room->save();

	        $notification = array(
	            'message' => 'New training officer has been successfully added', 
	            'alert-type' => 'success'
	        );

			return redirect('/maintenance/room')->with($notification);
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

	public function updateRoom(Request $request){
		$rooms = Trainingroom::all();
		$check = true;
		$messages = "";
		foreach($rooms as $rooms)
		{
			if($rooms->building_id.$rooms->floor_id.strtolower(trim($rooms->room_no)).$rooms->id != $request->building_id.$request->floor_id.strtolower(trim($request->room_no)).$request->id)
			{
				if($rooms->building_id.$rooms->floor_id.strtolower(trim($rooms->room_no)) == $request->building_id.$request->floor_id.strtolower(trim($request->room_no)))
				{
					$check = false;
					$messages .= "Duplication of room is not allowed";
				}
			}
		}
		if($check)
		{
			$room = Trainingroom::find($request->id);
			$room->room_no = $request->room_no;
			$room->capacity = $request->capacity;
			$room->building_id = $request->building_id;
			$room->floor_id = $request->floor_id;
			$room->save();

	        $notification = array(
	            'message' => 'Training officer has been successfully updated', 
	            'alert-type' => 'success'
	        );

			return redirect('/maintenance/room')->with($notification);
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

	public function deleteRoom(Request $request){
		$room = Trainingroom::find($request->id);
		$room->active = 0;
		$room->save();

        $notification = array(
            'message' => 'Training officer has been successfully removed', 
            'alert-type' => 'success'
        );

		return redirect('/maintenance/room')->with($notification);
	}

	public function getFloor(Request $request){
		$data = Floor::select('floorName','id')->where('building_id',$request->id)->get();
		return response()->json($data);
	}


	public function getFAR(Request $request){
		$data = Trainingroom::select('room_no','id')
				->where('building_id',$request->building_id)
				->where('floor_id',$request->floor_id)->get();
		return response()->json($data);
	}

	public function getRoom(Request $request){
		$data = Trainingroom::select('room_no','id')->where('floor_id',$request->floor_id)->where('active',1)->get();
		return response()->json($data);
	}

	public function viewArchive(){
		$room = Trainingroom::all()->where('active','=',0);
		$building = Building::all()->where('active','=',1);
		return view('/admin/maintenance/archiveroom',compact('room','building'));
	}

	public function activateRoom(Request $request){
		$room = Trainingroom::find($request->id);
		$room->active = 1;
		$room->save();

        $notification = array(
            'message' => 'Training officer has been successfully activated', 
            'alert-type' => 'success'
        );

		return redirect('/maintenance/room')->with($notification);
	}

}
