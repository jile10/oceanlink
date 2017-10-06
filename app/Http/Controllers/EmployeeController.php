<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use App\Employee;
use App\User;
use Carbon\Carbon;
use Auth;
class EmployeeController extends Controller
{
    public function viewEmployee(){
    	$position = Position::all();
    	$employee = Employee::all()->where('active','=',1);
    	return view('admin.maintenance.employee',compact('position','employee'));
    }

    public function createEmployee(Request $request){
    	$user = new User;
    	$user->email = $request->email;
    	$user->password = bcrypt(strtolower($request->firstName. $request->lastName));
        $user->position_id = $request->position_id;
    	$user->save();
    	$user = User::all();
    	$last = $user->last();
    	$user_id = $last->id;
    	$emp = new Employee;

    	$emp->firstName = $request->firstName;
    	$emp->middleName = $request->middleName;
    	$emp->lastName = $request->lastName;
    	$emp->street = $request->street;
    	$emp->barangay = $request->barangay;
    	$emp->city = $request->city;
    	$emp->dob = Carbon::parse($request->dob)->format("Y-m-d");
    	$emp->gender = $request->gender;
    	$emp->contact = $request->contact;
    	$emp->user_id = $user_id;
    	$emp->save();
    	return redirect('maintenance/employee');
    }

    public function updateEmployee(Request $request)
    {
    	$emp = Employee::find($request->id);
    	$emp->firstName = $request->firstName;
    	$emp->middleName = $request->middleName;
    	$emp->lastName = $request->lastName;
    	$emp->street = $request->street;
    	$emp->barangay = $request->barangay;
    	$emp->city = $request->city;
    	$emp->dob = $request->dob;
    	$emp->gender = $request->gender;
    	$emp->contact = $request->contact;
    	$emp->position_id = $request->position_id;
    	$emp->user_id = $request->user_id;
    	$emp->save();
    	return redirect('maintenance/employee');
    }

    public function deleteEmployee(Request $request)
    {
    	$emp = Employee::find($request->id);
    	$emp->active = 0;
    	$emp->save();
    	return redirect('maintenance/employee');
    }

    public function updateFirstName(Request $request)
    {
        $employee = Auth::user()->employee;
        $employee->firstName = $request->firstName;
        $employee->middleName = $request->middleName;
        $employee->lastName = $request->lastName;
        if($employee->save())
        {
            return response()->json(array('message'=>"Full Name has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateAddress(Request $request)
    {
        $employee = Auth::user()->employee;
        $employee->street = $request->street;
        $employee->barangay = $request->barangay;
        $employee->city = $request->city;
        if($employee->save())
        {
            return response()->json(array('message'=>"Address has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $user->email = $request->email;
        if($user->save())
        {
            return response()->json(array('message'=>"Email has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateDob(Request $request)
    {
        $employee = Auth::user()->employee;
        $employee->dob = Carbon::parse($request->dob)->format('Y-m-d');
        if($employee->save())
        {
            return response()->json(array('message'=>"Date of birth has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }

    public function updateContact(Request $request)
    {
        $employee = Auth::user()->employee;
        $employee->contact = $request->contact;
        if($employee->save())
        {
            return response()->json(array('message'=>"Date of birth has been successfully updated",'alert-type'=>'success'));
        }
        else
        {

            return response()->json(array('message'=>"Cannot update",'alert-type'=>'error'));
        }
    }
}
