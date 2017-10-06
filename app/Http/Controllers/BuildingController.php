<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Building;

class BuildingController extends Controller
{
	public function viewBuilding(){
		$building = Building::all()->where('active','=',1);
		return view('admin/maintenance/building',compact('building'));
	}

	public function insertBuilding(Request $request){
		$buildings = Building::all();
		$check = true;
		$messages ="";
		foreach($buildings as $buildings){
			if(strtolower(trim($buildings->buildingName)) == strtolower(trim($request->buildingName))){
				$check = false;
				$messages .="Duplication of name is not allowed";
			}
		}

		if($check){
			$building = new Building;
			$building->buildingName = $request->buildingName;
			$building->buildingLocation = $request->buildingLocation;
			$building->save();

			$notification = array(
				'message' => 'New building has been successfully added', 
				'alert-type' => 'success'
			);
			return redirect('/maintenance/building')->with($notification);
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

	public function updateBuilding(Request $request){
		$buildings = Building::all();
		$check = true;
		$messages ="";
		foreach($buildings as $buildings){
			if(strtolower(trim($buildings->buildingName)).$buildings->id != strtolower(trim($request->buildingName)).$request->id)
			{
				if(strtolower(trim($buildings->buildingName)) == strtolower(trim($request->buildingName))){
					$check = false;
					$messages .="Duplication of name is not allowed";
				}
			}
			
		}

		if($check)
		{
			$building = Building::find($request->id);
			$building->buildingName = $request->buildingName;
			$building->buildingLocation = $request->buildingLocation;
			$building->save();

			$notification = array(
				'message' => 'Building has been successfully updated', 
				'alert-type' => 'success'
			);
			return redirect('/maintenance/building')->with($notification);
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

	public function deleteBuilding(Request $request){
		$building = Building::find($request->id);

		$building->active = 0;
		$building->save();

		$notification = array(
			'message' => 'Building has been successfully removed', 
			'alert-type' => 'success'
		);
		return redirect('/maintenance/building')->with($notification);
	}

	public function viewArchive(){
		$building = Building::all()->where('active','=',0);
		return view('admin/maintenance/archivebuilding',compact('building'));
	}

	public function activateBuilding(Request $request){
		$building = Building::find($request->id);

		$building->active = 1;
		$building->save();

		$notification = array(
			'message' => 'Building has been successfully activated', 
			'alert-type' => 'success'
		);
		return redirect('/maintenance/building')->with($notification);
	}
}
