<?php

namespace App\Http\Controllers\Trxn;

use App\Http\Controllers\Controller;
use App\Mail\PenKeyMail;
use Illuminate\Http\Request;
use App\Models\TransactionHistory;
use App\Models\PenKey\PensionKey;
use App\Models\PenRey\PenRemitance;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Passport;


class NewTransactionsController extends Controller
{


    public function credit_employee(Request $request)
    {

        $user = auth()->user();

        $eem_code = $request->input('employee_code');

        $dt = Carbon::now();
        $date = $dt->addSeconds(-1);
        $confirm_rows = PenRemitance::where('user_id', $user->id)
        ->where('employee_code', $eem_code)
        ->where('amount_credited', $request->input('amount'))
        ->whereDate('created_at', '>=', $date)->get();

        $employee = User::where('pen_code', $eem_code)
        ->where('email_verified_at', null)->get();

        if(count($employee)>0){
            $msg["message"] = "This user account is not verified";
            return response()->json($msg, 403);
        }
        $amount = $request->input('amount');
        if(count($confirm_rows)>0){
            $msg["message"] = "Account credited already";
            return response()->json($msg, 208);
        }else{
            $credit = PenRemitance::create([
                'user_id' => $user->id,
                'employer_name' => $user->name,
                'employee_code' => $eem_code,
                'amount_credited' => $amount,
                'employer_code' => $user->pen_code,
            ]);
            // transaction was successful
        if($credit){
            $msg['message'] = 'Employee Account has been credited successfully';
            $msg['credit'] = 'Amount credited: '.$amount;
            $msg['status'] = 201;
            return $msg;
        }else {
            $res['message'] = 'Accountt can not be updated at this time!';
            return response()->json($res, 403);
            }
        }
  }

    /**
	 * Get a single visitor
	 *
	 * @param  int get a transaction keys
	 * @return JSON
	 */
    public function show($id)
    {  
    //
    }
       
}
