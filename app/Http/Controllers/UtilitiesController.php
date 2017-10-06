<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UtilitiesController extends Controller
{
    public function viewUtilities(){
    	
    	return view('admin/utilities/companyinfo');
    }
}
