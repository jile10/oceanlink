<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groupapplication;
use App\Payment;
use App\Cheque;
use App\Enrollee;
use App\Account;
use Carbon\Carbon;
use App\Classdetail;
use PDF;
use Terbilang;
use App\Accountdetail;
use App\Scheduledprogram;
use App\Groupapplicationdetail;
class CollectionController extends Controller
{
    //single
    public function viewSCollection(){
        $payment = Payment::all();
        $account = Account::all();
        $acount = array();
        $x =0;
        foreach($account as $accounts){
            if(count($accounts->groupapplication)>0){
                $check = false;
                foreach($accounts->groupapplication->groupapplicationdetail as $details ){ 
                     if($details->status == 2){
                        $check = true;
                     }
                }
                $acount[$x] = [
                    "id" => $accounts->id,
                    "account_no" => $accounts->accountNumber,
                    "account_name" => $accounts->groupapplication->orgName,
                    "balance" => $accounts->accountdetail->sum('balance'),
                    "check" =>$check,
                ];
                $x++;
            }
        }
        return view('admin.collection.single.collection',compact('account','acount'));
    }

    public function viewNext(Request $request){
        $request->session()->put('account_id',$request->account_id);
        return redirect('/collection/single/account');
    }

    public function viewAccount(){
        $payment = Payment::all();
        $account = Account::find(session('account_id'));
        $total=0;
        foreach($account->accountdetail as $details){
            $total+=$details->balance;
        }
        return view('admin.collection.single.account',compact('account','payment','total'));
    }

    public function insertSCollection(Request $request){
        $balance = 0;
        if($request->change == "yes"){
            $payment = new Payment;
            $payment->amount = $request->amount;
            $payment->amountChange = $request->amount - $request->amountPay;
            $payment->paymentType = 1;
            $payment->paymentDate = Carbon::parse($request->paymentDate)->format('y-m-d');
            $payment->paymentNumber =  $request->paymentNumber;
            $payment->account_id = $request->account_id;
            $payment->save();

             for($i=0; $i<count($request->paymentMode);$i++){
                $accountdetail = Accountdetail::find($request->accountdetail_id[$i]);
                if($request->paymentMode[$i] == 1){
                    $accountdetail->status = 2;
                    $balance = $accountdetail->balance/2;
                    $accountdetail->balance = $accountdetail->balance/2;
                    $accountdetail->paymentMode = 2;
                }else if($request->paymentMode[$i] == 2){
                    $accountdetail->status = 3;
                    $balance = 0;
                    $accountdetail->balance = 0;
                }
                $accountdetail->save();
            }
        }
        else if($request->change == "maybe"){
            echo "awtsu";
            $payment = new Payment;
            $payment->amount = $request->amount;
            $payment->amountChange = $request->amount - $request->totalFee;
            $payment->paymentType = 1;
            $payment->paymentDate = Carbon::parse($request->paymentDate)->format('y-m-d');
            $payment->paymentNumber =  $request->paymentNumber;
            $payment->account_id = $request->account_id;
            $payment->save();

            // account details
            for($i=0; $i<count($request->paymentMode);$i++){
                $accountdetail = Accountdetail::find($request->accountdetail_id[$i]);
                if($request->paymentMode[$i] == 1){
                    $accountdetail->status = 3;
                    $accountdetail->paymentMode = 2;
                    $accountdetail->balance = 0;
                    $balance = 0;
                }
                else if($request->paymentMode[$i] == 2){
                    $accountdetail->status = 3;
                    $accountdetail->balance = 0;
                    $balance = 0;
                }
                $accountdetail->save();
            }
        }
        else
        {
            $a=0;
            foreach($request->accountdetail_id as $ids){
                $details = Accountdetail::find($ids);
                if($details->paymentMode == 1){
                    $a++;
                }
            }
            $equalamount = ($request->amount - $request->amountPay)/$a;
            $payment = new Payment;
            $payment->amount = $request->amount;
            $payment->amountChange = 0;
            $payment->paymentType = 1;
            $payment->paymentDate = Carbon::parse($request->paymentDate)->format('y-m-d');
            $payment->paymentNumber =  $request->paymentNumber;
            $payment->account_id = $request->account_id;
            $payment->save();

            // account details
            for($i=0; $i<count($request->paymentMode);$i++){
                $accountdetail = Accountdetail::find($request->accountdetail_id[$i]);
                if($request->paymentMode[$i] == 1){
                    $accountdetail->status = 2;
                    $accountdetail->paymentMode = 2;
                    $accountdetail->balance = ($accountdetail->balance/2) - $equalamount;
                    $balance = ($accountdetail->balance/2) - $equalamount;
                }
                else if($request->paymentMode[$i] == 2){
                    $accountdetail->status = 3;
                    $accountdetail->balance = 0;
                    $balance = 0;
                }
                $accountdetail->save();
            }
        }
        //classdetail
        if(count($request->enrollee_id)>0)
        {
            foreach($request->scheduledprogram_id as $sprogs){
                $sprog = Scheduledprogram::find($sprogs);
                $classdetail = Classdetail::where('trainingclass_id',$sprog->trainingclass->id)->where('enrollee_id',$request->enrollee_id)->get();
                foreach($classdetail as $classdetail){
                    $classdetail = Classdetail::find($classdetail->id);
                    if($balance >0)
                        $classdetail->status = 2;
                    else
                        $classdetail->status = 3;
                    $classdetail->save();
                }
            }

            $request->session()->flash('receipt',1);
        }
        else if(count($request->groupapplication_id)>0){
            foreach($request->scheduledprogram_id as $sprogs){
                $sprog = Scheduledprogram::find($sprogs);
                $groupapplicationdetail = Groupapplicationdetail::where('trainingclass_id',$sprog->trainingclass->id)->get();
                foreach($groupapplicationdetail as $groupapplicationdetail){
                    $groupapplicationdetail = Groupapplicationdetail::find($groupapplicationdetail->id);
                    if($balance >0)
                        $groupapplicationdetail->status = 2;
                    else
                        $groupapplicationdetail->status = 3;
                    $groupapplicationdetail->save();
                }    
            }

            $request->session()->flash('receipt',2);
        }
       
        //regicard
        // $enrollee = Enrollee::find($request->enrollee_id);
        // $request->session()->put('enrollee',$enrollee);
        // $request->session()->put('sprog',$request->scheduledprogram_id);
        return redirect('/collection/single');
    }

    //group
    public function viewCollection(){
    	$payment = Payment::all();
    	$gapp = Groupapplication::all()->where('active','=',1);
    	return view('admin.collection.group.collection',compact('gapp','payment'));
    }

    public function insertInCashCollection(Request $request){
    	$payment = new Payment;
    	$payment->amount = $request->amount;
        $payment->amountChange = $request->amount - $request->amountPay;
    	$payment->paymentType = 1;
    	$payment->paymentDate = Carbon::parse($request->paymentDate)->format('y-m-d');
    	$payment->paymentNumber = $request->paymentNumber;
    	$payment->account_id = $request->account_id;
    	$payment->save();

    	$account = Account::find($request->account_id);
        if($account->paymentMode == 1){
            $balance = $account->balance - $request->amountPay;
            $account->balance = $balance;
            $account->paymentMode = 2;
            $account->save();
        }
        else{
            $account->balance = 0;
            $account->save();
        }

    	$gapp = Groupapplication::find($request->groupapplication_id);
    	foreach ($gapp->groupdetail as $detail ) {
    		$enrollee = Enrollee::find($detail->enrollee_id);
    		$enrollee->status_id = 2;
    		$enrollee->save();
    	}
    	return redirect('/collection/group');
    }

    public function insertCheckCollection(Request $request){
    	$payment = new Payment;
    	$payment->amount = $request->amount;
        $payment->amountChange = 0;
    	$payment->paymentType = 1;
    	$payment->paymentDate = Carbon::parse($request->paymentDate)->format('y-m-d');
    	$payment->paymentNumber = $request->paymentNumber;
    	$payment->account_id = $request->account_id;
    	$payment->save();
    	$payment = Payment::all();
    	$payment = $payment->last();

    	$cheque = new Cheque;
    	$cheque->accountNumber = $request->accountNumber;
    	$cheque->accountName = $request->accountName;
    	$cheque->checkNumber = $request->checkNumber;
    	$cheque->rtNumber = $request->rtNumber;
    	$cheque->payment_id = $payment->id;
    	$cheque->save();

    	$account = Account::find($request->account_id);
        if($account->paymentMode == 1){
            $balance = $account->balance - $request->amountPay;
            $account->balance = $balance;
            $account->paymentMode = 2;
            $account->save();
        }
        else{
            $account->balance = 0;
            $account->save();
        }

    	$gapp = Groupapplication::find($request->groupapplication_id);
    	foreach ($gapp->groupdetail as $detail ) {
    		$enrollee = Enrollee::find($detail->enrollee_id);
    		$enrollee->status_id = 2;
    		$enrollee->save();
    	}
        return redirect('/collection/group');
    }

    public function viewHistory(){
        $payment = Payment::query()->distinct()->get();
        return view('admin.collection.history',compact('payment'));

    }

    public function printReceiptS(){
        $account = Payment::all();
        $account = $account->last();
        $money = Terbilang::make($account->amount - $account->amountChange,' PESO ONLY');
        $pdf = PDF::loadView('pdf/receipt',['payment'=>$account,'money'=>$money])->setPaper([0,0,612,450]);
        return $pdf->stream('pdf.pdf');
    }

    public function printReceiptG(){
        $account = Payment::all();
        $account = $account->last();
        $money = Terbilang::make($account->amount - $account->amountChange,' PESO ONLY');
        $pdf = PDF::loadView('pdf/greceipt',['payment'=>$account,'money'=>$money])->setPaper([0,0,612,396],'portrait');
        return $pdf->download('pdf.pdf');
    }
}
