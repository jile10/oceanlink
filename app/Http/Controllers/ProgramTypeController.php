<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programtype;
class ProgramTypeController extends Controller
{
    public function viewType(){
    	$type = Programtype::all()->where('active','=',1);
    	return view('admin/maintenance/type',compact('type'));
    }

    public function insertType(Request $request){
        $type = Programtype::all();
        $check = false;
        $messages = "";
        foreach($type as $types)
        {
            if(strtolower($types->typeName) == strtolower(trim($request->typeName))){
                $check = true;
                $messages = "Duplication of data is not allowed";
            }
        }
        if($check)
        {
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        else{
        	$type = new Programtype;
        	$type->typeName = trim($request->typeName);
        	$type->typeDesc = trim($request->typeDesc);
        	$type->save();

            $notification = array(
                'message' => 'New program type has been successfully added', 
                'alert-type' => 'success'
            );
            return redirect('/maintenance/ptype')->with($notification);
        }
    }

    public function updateType(Request $request){
        $type = Programtype::all();
        $check = false;
        $messages = "";

        foreach($type as $types)
        {
            if(strtolower($types->typeName).$types->id != strtolower(trim($request->typeName)).$request->id)
            {
                if(strtolower($types->typeName) == strtolower(trim($request->typeName))){
                    $check = true;
                    $messages = "Duplication of data is not allowed";
                }
            }
        }

        if($check)
        {
            $notification = array(
                'message' => $messages, 
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }
        else
    	{
            $type = Programtype::find($request->id);
            $type->typeName = $request->typeName;
            $type->typeDesc = $request->typeDesc;
            $type->save();
    
            $notification = array(
                'message' => 'Program type has been successfully updated', 
                'alert-type' => 'success'
            );
    
            return redirect('/maintenance/ptype')->with($notification);
        }
    }

    public function deleteType(Request $request){
    	$type = Programtype::find($request->id);
    	$type->active=0;
    	$type->save();

        $notification = array(
            'message' => 'Program type has been successfully removed', 
            'alert-type' => 'success'
        );

    	return redirect('/maintenance/ptype')->with($notification);
    }

    public function viewArchive(){
        $type = Programtype::all()->where('active','=',0);
        return view('admin/maintenance/archivetype',compact('type'));
    }

    public function activateType(Request $request){
        $type = Programtype::find($request->id);
        $type->active=1;
        $type->save();

        $notification = array(
            'message' => 'Program type has been successfully activated', 
            'alert-type' => 'success'
        );

        return redirect('/maintenance/ptype')->with($notification);
    }
}
