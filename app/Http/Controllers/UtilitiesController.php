<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Companyinfo;
class UtilitiesController extends Controller
{
    public function viewUtilities(){
    	$companyinfo = Companyinfo::all()->first();
    	return view('admin/utilities/companyinfo',compact('companyinfo'));
    }

    public function updateCompanyName(Request $request)
    {
    	$cinfo = Companyinfo::whereId($request->pk)->first();
        $cinfo->name = $request->value;
        if($cinfo->save())
        {
            return response()->json(array('message'=>"Company name has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Canno update name",'alert-type'=>'error'));
        }
    }

    public function updateCompanyAddress(Request $request)
    {
    	$cinfo = Companyinfo::whereId($request->pk)->first();
        $cinfo->address = $request->value;
        if($cinfo->save())
        {
            return response()->json(array('message'=>"Company Address has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Canno update name",'alert-type'=>'error'));
        }
    }

    public function updateTDirector(Request $request)
    {
    	$cinfo = Companyinfo::whereId($request->pk)->first();
        $cinfo->director = $request->value;
        if($cinfo->save())
        {
            return response()->json(array('message'=>"Training Director has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Canno update name",'alert-type'=>'error'));
        }
    }

    public function updateCOfficer(Request $request)
    {
    	$cinfo = Companyinfo::whereId($request->pk)->first();
        $cinfo->chiefofficer = $request->value;
        if($cinfo->save())
        {
            return response()->json(array('message'=>"Chief Training Officer has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Canno update name",'alert-type'=>'error'));
        }
    }

    public function updateRegistrar(Request $request)
    {
    	$cinfo = Companyinfo::whereId($request->pk)->first();
        $cinfo->registrar = $request->value;
        if($cinfo->save())
        {
            return response()->json(array('message'=>"Registrar has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Canno update name",'alert-type'=>'error'));
        }
    }
}
