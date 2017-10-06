<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Position;

class PositionController extends Controller
{
	public function viewPosition(){
		$position = Position::all()->where('active','=',1);
		return view('admin/maintenance/position',compact('position'));
	}

	public function createPosition(Request $request){
		$position = new Position;
		$position->positionName = $request->positionName;
		$position->positionDesc = $request->positionDesc;
		$position->save();

		return redirect('/maintenance/position');
	}

	public function updatePosition(Request $request){
		$position = Position::find($request->id);
		$position->positionName = $request->positionName;
		$position->positionDesc = $request->positionDesc;
		$position->save();

		return redirect('/maintenance/position');
	}
	public function deletePosition(Request $request){
		$position = Position::find($request->id);
		$position->active = 0;
		$position->save();

		return redirect('/maintenance/position');
	}
}
