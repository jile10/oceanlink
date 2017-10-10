<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Trainingofficer;
use Carbon\Carbon;
class TOfficerController extends Controller
{
    public function viewTOfficer(){
    	$tofficer = Trainingofficer::all()->where('active','=',1);
    	return view('admin/maintenance/tofficer',compact('tofficer'));
    }

    public function insertTOfficer(Request $request){
        $officer = Trainingofficer::all();
        $check = true;
        $messages = "";
        foreach ($officer as $officers) {
            if(strtolower(trim($request->firstName) . ' '.trim($request->middleName) . ' ' . trim($request->lastName)) == strtolower(trim($officers->firstName). ' ' .trim($officers->middleName) .' '.trim($officers->lastName))){
                $check = false;
                $messages .= "Duplication of name is not allowed. ";
            }
            if(strtolower(trim($request->email)) == strtolower(trim($officers->user->email)))
            {
                $check = false;
                $messages .= "Duplication of email is not allowed. ";
            }
        }
        if($check)
    	{
            $user = new User;
            $user->email = $request->email;
            $user->password = bcrypt(strtolower($request->firstName . ''. $request->lastName));
            $user->position_id = 4;
            $user->save();
            $user = User::all();
            $last = $user->last();
            $user_id = $last->id;
            $tofficer = new Trainingofficer;
            $tofficer->firstName = $request->firstName;
            $tofficer->middleName = $request->middleName;
            $tofficer->lastName = $request->lastName;
            $tofficer->street = $request->street;
            $tofficer->barangay = $request->barangay;
            $tofficer->city = $request->city;
            $tofficer->dob = Carbon::parse($request->dob)->format('Y-m-d');
            $tofficer->contact = $request->contact;
            $tofficer->gender = $request->gender;
            $tofficer->user_id = $user_id;
            $tofficer->save();
    
            $notification = array(
                'message' => 'New training officer has been successfully added', 
                'alert-type' => 'success'
            );
    
            return redirect('/maintenance/tofficer')->with($notification);
        }
        else{
            
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function updateTOfficer(Request $request){
        $officer = Trainingofficer::all();
        $check = true;
        $messages = "";
        foreach ($officer as $officers) {
            if(strtolower(trim($request->firstName) . ' '.trim($request->middleName) . ' ' . trim($request->lastName)).$request->id != strtolower(trim($officers->firstName). ' ' .trim($officers->middleName) .' '.trim($officers->lastName)).$officers->id)
            {
                if(strtolower(trim($request->firstName) . ' '.trim($request->middleName) . ' ' . trim($request->lastName)) == strtolower(trim($officers->firstName). ' ' .trim($officers->middleName) .' '.trim($officers->lastName))){
                    $check = false;
                    $messages .= "Duplication of name is not allowed. ";
                }
                if(strtolower(trim($request->email)) == strtolower(trim($officers->user->email)))
                {
                    $check = false;
                    $messages .= "Duplication of email is not allowed. ";
                }
            }
        }
        if($check)
        {
        	$tofficer = Trainingofficer::find($request->id);
        	$tofficer->firstName = $request->firstName;
        	$tofficer->middleName = $request->middleName;
        	$tofficer->lastName = $request->lastName;
        	$tofficer->street = $request->street;
        	$tofficer->barangay = $request->barangay;
        	$tofficer->city = $request->city;
            $tofficer->dob = Carbon::parse($request->dob)->format('Y-m-d');
        	$tofficer->contact = $request->contact;
        	$tofficer->gender = $request->gender;
        	$tofficer->save();

            $notification = array(
                'message' => 'Training officer has been successfully updated', 
                'alert-type' => 'success'
            );

        	return redirect('/maintenance/tofficer')->with($notification);
        }
        else{
            
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function deleteTOfficer(Request $request){
    	
    	$tofficer = Trainingofficer::find($request->id);
    	$tofficer->active = 0;
    	$tofficer->save();

        $notification = array(
            'message' => 'Training officer has been successfully removed', 
            'alert-type' => 'warning'
        );


    	return redirect('/maintenance/tofficer')->with($notification);
    }

    public function viewArchive(){
        $tofficer = Trainingofficer::all()->where('active','=',0);
        return view('admin/maintenance/archivetofficer',compact('tofficer'));
    }

    public function activateTOfficer(Request $request){
        
        $tofficer = Trainingofficer::find($request->id);
        $tofficer->active = 1;
        $tofficer->save();

        $notification = array(
            'message' => 'Training officer has been successfully activated', 
            'alert-type' => 'success'
        );


        return redirect('/maintenance/tofficer')->with($notification);
    }
}
