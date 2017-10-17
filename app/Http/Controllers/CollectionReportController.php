<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Payment;
use Carbon\Carbon;
use App\Accountdetail;
use App\Account;
use App\Refund;
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
            $accountName = "";
            if ($results->account->has('enrollee')) {
                $accountName = $results->account->enrollee->firstName . ' '. 
                                                $results->account->enrollee->middleName .' '. 
                                                $results->account->enrollee->lastName;
            }
            else{
                $accountName = $results->account->groupapplication->orgName;
            }
            $monthlyArray[$x] = [
                "accountNumber" =>$results->account->accountNumber,
                "accountName" => $accountName,
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
            $accountName = "";
            if ($results->account->has('enrollee')) {
                $accountName = $results->account->enrollee->firstName . ' '. 
                                                $results->account->enrollee->middleName .' '. 
                                                $results->account->enrollee->lastName;
            }
            else{
                $accountName = $results->account->groupapplication->orgName;
            }
            $yearlyArray[$x] = [
                "accountNumber" =>$results->account->accountNumber,
                "accountName" => $accountName,
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
            $accountName = "";
            if ($results->account->has('enrollee')) {
                $accountName = $results->account->enrollee->firstName . ' '. 
                                                $results->account->enrollee->middleName .' '. 
                                                $results->account->enrollee->lastName;
            }
            else{
                $accountName = $results->account->groupapplication->orgName;
            }
            $dateRangeArray[$x] = [
                "accountNumber" =>$results->account->accountNumber,
                "accountName" => $accountName,
                "paymentDate" =>$results->paymentDate,
                "amount" =>$results->amount
            ];
            $x++;
        }
        return response()->json($dateRangeArray);

	}

    public function viewAccount(){
        return view('admin/reports/accountbalance');
    }

    public function getAccountYearly(Request $request){
        $year = $request->yearly_year;
        $account = Account::all();
        $accountAll = array();
        $x=0;
        foreach($account as $accounts){
            $total=0;
            foreach ($accounts->accountdetail as $details) {
                if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
                {
                    if($year == Carbon::parse($details->created_at)->format('Y')){
                        $total += $details->balance;
                    }
                }
            }
            $name = "";
            if(count($accounts->enrollee)>0)
            {
                $name = $accounts->enrollee->firstName . ' '. 
                                            $accounts->enrollee->middleName .' '. 
                                            $accounts->enrollee->lastName;
            }
            else
                $name = $accounts->groupapplication->orgName;
            if($total>0)
            {
                $accountAll[$x] = [
                    "id"=>$accounts->id,
                    "accountNumber" => $accounts->accountNumber,
                    "accountName" =>$name,
                    "balance"=>number_format($total,2),
                ];
                $x++;
            }
        }
        return response()->json($accountAll);
    }

    public function getAccountMonthly(Request $request){
        $month = $request->monthly_month;
        $year = $request->monthly_year;

        $account = Account::all();
        $accountAll = array();
        $x=0;
        foreach($account as $accounts){
            $total=0;
            foreach ($accounts->accountdetail as $details) {
                if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
                {
                    if($year == Carbon::parse($details->created_at)->format('Y') && $month == Carbon::parse($details->created_at)->format('F')){
                        $total += $details->balance;
                    }
                }
            }
            $name = "";
            if(count($accounts->enrollee)>0)
            {
                $name = $accounts->enrollee->firstName . ' '. 
                                            $accounts->enrollee->middleName .' '. 
                                            $accounts->enrollee->lastName;
            }
            else
                $name = $accounts->groupapplication->orgName;
            if($total>0)
            {
                $accountAll[$x] = [
                    "id"=>$accounts->id,
                    "accountNumber" => $accounts->accountNumber,
                    "accountName" =>$name,
                    "balance"=>number_format($total,2),
                ];
                $x++;
            }
        }
        return response()->json($accountAll);
    }

    public function getAccountDateRange(Request $request){
        $dateFrom = Carbon::parse($request->range_dateFrom);
        $dateTo = Carbon::parse($request->range_dateTo);

        $account = Account::all();
        $accountAll = array();
        $x=0;
        foreach($account as $accounts){
            $total=0;
            foreach ($accounts->accountdetail as $details) {
                if($details->scheduledprogram->trainingclass->status != 1 && $details->scheduledprogram->trainingclass->status != 0)
                {
                    if(Carbon::parse($details->created_at)->between($dateFrom,$dateTo)){
                        $total += $details->balance;
                    }
                }
            }
            $name = "";
            if(count($accounts->enrollee)>0)
            {
                $name = $accounts->enrollee->firstName . ' '. 
                                            $accounts->enrollee->middleName .' '. 
                                            $accounts->enrollee->lastName;
            }
            else
                $name = $accounts->groupapplication->orgName;
            if($total>0)
            {
                $accountAll[$x] = [
                    "id"=>$accounts->id,
                    "accountNumber" => $accounts->accountNumber,
                    "accountName" =>$name,
                    "balance"=>number_format($total,2),
                ];
                $x++;
            }
        }
        return response()->json($accountAll);
    }

    public function viewRefund(){
        return view('admin/reports/refund');
    }

    public function getRefundMonthly(Request $request){
        $month = $request->monthly_month;
        $year = $request->monthly_year;

        $result = Refund::whereYear('date', '=', $year )
                            ->whereMonth('date', '=', Carbon::parse($month)->format('m'))
                            ->get();
        $monthlyArray = array();
        $x=0;

        foreach($result as $results){
            $monthlyArray[$x] = [
                "name" =>$results->enrollee->firstName . ' ' . $results->enrollee->middleName . ' ' . $results->enrollee->lastName,
                "course" =>$results->trainingclass->scheduledprogram->rate->program->programName . ' (' . $results->trainingclass->scheduledprogram->rate->duration . ' Hours)',
                "date" =>Carbon::parse($results->date)->format('F d,Y'),
                "amount" =>number_format($results->amount,2)
            ];
            $x++;
        }

        return response()->json($monthlyArray);

    }

    public function getRefundYearly(Request $request){
        $year = $request->yearly_year;

        $result = Refund::whereYear('date', '=', $year )
                                            ->get();
        $yearlyArray = array();
        $x=0;

        foreach($result as $results){
            $yearlyArray[$x] = [
            "name" =>$results->enrollee->firstName . ' ' . $results->enrollee->middleName . ' ' . $results->enrollee->lastName,
            "course" =>$results->trainingclass->scheduledprogram->rate->program->programName . ' (' . $results->trainingclass->scheduledprogram->rate->duration . ' Hours)',
            "date" =>Carbon::parse($results->date)->format('F d,Y'),
            "amount" =>number_format($results->amount,2)
            ];
            $x++;
        }
        return response()->json($yearlyArray);
    }

    public function getRefundDateRange(Request $request){
        $dateFrom = Carbon::parse($request->range_dateFrom)->format("Y-m-d");
        $dateTo = Carbon::parse($request->range_dateTo)->format("Y-m-d");

        $result = Refund::where('date', '>=' , $dateFrom)
                                            ->where('date', '<=' , $dateTo)
                                            ->get();
        $dateRangeArray = array();
        $x=0;

        foreach($result as $results){
            $dateRangeArray[$x] = [
                "name" =>$results->enrollee->firstName . ' ' . $results->enrollee->middleName . ' ' . $results->enrollee->lastName,
                "course" =>$results->trainingclass->scheduledprogram->rate->program->programName . ' (' . $results->trainingclass->scheduledprogram->rate->duration . ' Hours)',
                "date" =>Carbon::parse($results->date)->format('F d,Y'),
                "amount" =>number_format($results->amount,2)
            ];
            $x++;
        }
        return response()->json($dateRangeArray);
    }
}
