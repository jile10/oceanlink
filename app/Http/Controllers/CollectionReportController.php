<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;
class CollectionReportController extends Controller
{
	public function viewReport(){
		return view('admin/reports/collection_report');
	}
	public function getMonthly(Request $request){
		$month = $request->monthly_month;
		$year = $request->monthly_year;

		$result = Payment::whereYear('paymentDate', '=', $year )
											->whereMonth('paymentDate', '=', Carbon::parse($month)->format('m'))
											->get();
		$monthlyArray = array();
		$x=0;

    foreach($result as $results){
        $monthlyArray[$x] = [
            "accountNumber" =>$results->account->accountNumber,
            "accountName" =>$results->account->enrollee->firstName . ' '. 
            								$results->account->enrollee->middleName .' '. 
            								$results->account->enrollee->lastName,
            "paymentDate" =>$results->paymentDate,
            "amount" =>$results->amount
        ];
        $x++;
    }

    return response()->json($monthlyArray);

	}

	public function getYearly(Request $request){
		$year = $request->yearly_year;

		$result = Payment::whereYear('paymentDate', '=', $year )
											->get();
		$yearlyArray = array();
		$x=0;

    foreach($result as $results){
        $yearlyArray[$x] = [
            "accountNumber" =>$results->account->accountNumber,
            "accountName" =>$results->account->enrollee->firstName . ' '. 
            								$results->account->enrollee->middleName .' '. 
            								$results->account->enrollee->lastName,
            "paymentDate" =>$results->paymentDate,
            "amount" =>$results->amount
        ];
        $x++;
    }

    return response()->json($yearlyArray);

	}

	public function getDateRange(Request $request){
		$dateFrom = Carbon::parse($request->range_dateFrom)->format("Y-m-d");
		$dateTo = Carbon::parse($request->range_dateTo)->format("Y-m-d");

		$result = Payment::where('paymentDate', '>=' , $dateFrom)//whereBetween('paymentDate', [$dateFrom , $dateTo])
											->where('paymentDate', '<=' , $dateTo)
											->get();
		$dateRangeArray = array();
		$x=0;

    foreach($result as $results){
        $dateRangeArray[$x] = [
            "accountNumber" =>$results->account->accountNumber,
            "accountName" =>$results->account->enrollee->firstName . ' '. 
            								$results->account->enrollee->middleName .' '. 
            								$results->account->enrollee->lastName,
            "paymentDate" =>$results->paymentDate,
            "amount" =>$results->amount
        ];
        $x++;
    }
    return response()->json($dateRangeArray);

	}
}
