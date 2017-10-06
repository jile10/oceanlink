<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vessel;
class VesselController extends Controller
{
    public function viewVessel(){
    	$vessel = Vessel::all()->where('active','=',1);
    	return view('admin/maintenance/vessel',compact('vessel'));
    }

    public function insertVessel(Request $request){
        $vessels = Vessel::all();
        $check = true;
        $messages = "";
        foreach($vessels as $vessels){
            if(strtolower(trim($vessels->vesselName)) == strtolower(trim($request->vesselName)))
            {
                $check = false;
                $messages .= "Duplication of name is not allowed. ";
            }
        }
        if($check)
        {
            $vessel = new Vessel;
            $vessel->vesselName = $request->vesselName;
            $vessel->vesselDesc = $request->vesselDesc;
            $vessel->vesselStatus = $request->vesselStatus;
            $vessel->save();
            $notification = array(
                'message' => 'New training officer has been successfully added', 
                'alert-type' => 'success'
            );

            return redirect('/maintenance/vessel')->with($notification);
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

    public function updateVessel(Request $request){
        $vessels = Vessel::all();
        $check = true;
        $messages = "";
        foreach($vessels as $vessels){
            if(strtolower(trim($vessels->vesselName)).$vessels->id != strtolower(trim($request->vesselName)).$request->id)
            {
                if(strtolower(trim($vessels->vesselName)) == strtolower(trim($request->vesselName)))
                {
                    $check = false;
                    $messages .= "Duplication of name is not allowed. ";
                }
            }
        }
        if($check)
        {
            $vessel = Vessel::find($request->id);
            $vessel->vesselName = $request->vesselName;
            $vessel->vesselDesc = $request->vesselDesc;
            $vessel->vesselStatus = $request->vesselStatus;
            $vessel->save();

            $notification = array(
                'message' => 'Vessel has been successfully updated', 
                'alert-type' => 'success'
            );

            return redirect('/maintenance/vessel')->with($notification);
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

    public function deleteVessel(Request $request){
    	$vessel = Vessel::find($request->id);
    	$vessel->active = 0;
    	$vessel->save();

        $notification = array(
            'message' => 'Vessel has been successfully removed', 
            'alert-type' => 'success'
        );

    	return redirect('/maintenance/vessel')->with($notification);
    }


    public function viewArchive(){
        $vessel = Vessel::all()->where('active','=',0);
        return view('admin/maintenance/archivevessel',compact('vessel'));
    }

    public function activateVessel(Request $request){
        $vessel = Vessel::find($request->id);
        $vessel->active = 1;
        $vessel->save();

        $notification = array(
            'message' => 'Vessel has been successfully activated', 
            'alert-type' => 'success'
        );

        return redirect('/maintenance/vessel')->with($notification);
    }
}
