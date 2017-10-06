<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\Programtype;
class ProgramController extends Controller
{
	public function viewProgram()
	{
		$type = Programtype::all()->where('active','=',1);
		$program = Program::all()->where('active','=',1);

		return view('admin/maintenance/program',compact('program','type'));
	}

	public function insertProgram(Request $request){
		$programs = Program::all();
		$check = true;
		$messages = "";
		foreach ($programs as $programs) {
			if(strtolower(trim($programs->programCode)) == strtolower(trim($request->programCode))){
				$check = false;
				$messages .= "Duplication of code is not allowed. ";
			}
			if(strtolower(trim($programs->programName)) == strtolower(trim($request->programName))){
				$check = false;
				$messages .= "Duplication of name is not allowed. ";
			}
		}
		if($check){
			$program = new Program;
			$program->programCode = $request->programCode;
			$program->programName = $request->programName;
			$program->programDesc = $request->programDesc;
			$program->programtype_id = $request->type_id;
			$program->save();
	        $notification = array(
	            'message' => 'New program has been successfully added', 
	            'alert-type' => 'success'
	        );

			return redirect('maintenance/program')->with($notification);
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

	public function updateProgram(Request $request){
		$programs = Program::all();
		$check = true;
		$messages = "";
		foreach ($programs as $programs) {
			if($programs->id != $request->id)
			{
				if(strtolower(trim($programs->programCode)). $programs->id != strtolower(trim($request->programCode)). $request->id)
				{
					if(strtolower(trim($programs->programCode)) == strtolower(trim($request->programCode))){
						$check = false;
						$messages .= "Duplication of code is not allowed. ";
					}
					if(strtolower(trim($programs->programName)) == strtolower(trim($request->programName))){
						$check = false;
						$messages .= "Duplication of name is not allowed. ";
					}
				}
			}
		}
		if($check)
		{
			$program = Program::find($request->id);
			$program->programCode = $request->programCode;
			$program->programName = $request->programName;
			$program->programDesc = $request->programDesc;
			$program->programtype_id = $request->type_id;
			$program->save();

	        $notification = array(
	            'message' => 'Program has been successfully updated', 
	            'alert-type' => 'success'
	        );

			return redirect('/maintenance/program')->with($notification);
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

	public function deleteProgram(Request $request){
		$program = Program::find($request->id);
		$program->active = 0;
		$program->save();

        $notification = array(
            'message' => 'Program has been successfully remove', 
            'alert-type' => 'success'
        );

		return redirect('maintenance/program')->with($notification);
	}


	public function viewArchive()
	{
		$type = Programtype::all()->where('active','=',1);
		$program = Program::all()->where('active','=',0);

		return view('admin/maintenance/archiveprogram',compact('program','type'));
	}

	public function activateProgram(Request $request){
		$program = Program::find($request->id);
		$program->active = 1;
		$program->save();

        $notification = array(
            'message' => 'Program has been successfully activate', 
            'alert-type' => 'success'
        );

		return redirect('maintenance/program')->with($notification);
	}
}
