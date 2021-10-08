<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
{
    public function index() {
        $employers = [];
        $employees = [];

        $users = User::all();
        foreach ($users as $user) {
            if($user->role == 1) {      
                array_push($employers, $user);
            }else if($user->role == 2){     
                array_push($employees, $user);
            }
        }
        $res['status']    = true;
        $res['employers']    = $employers;
        $res['employees'] = $employees;
        return response()->json($res, 200);
    }

    public function employee() {
        // $user = Auth::user(); //this is you active user logged in

        $user = DB::table('rsa_remitance')
        ->leftJoin('employees', function($join)
        {
            $join->on('rsa_remitance.employer_code','employees.employer_code');
        })
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->selectRaw('sum(rsa_remitance.amount_credited) as rsa_total, users.first_name, users.pen_code, users.username, users.email, employees.employer_code, employees.nok_fname, employees.nok_lname, employees.nok_phone, employees.nok_email')
        ->groupBy('users.first_name', 'rsa_remitance.employee_code', 'users.pen_code', 'users.username', 'users.email', 'employees.nok_fname', 'employees.employer_code', 'employees.nok_lname', 'employees.nok_phone', 'employees.nok_email')
        ->get();
        $res['status']    = true;
        $res['emp_profile']    = $user;
        return response()->json($user, 200);
    }

    public function employer() {
        $user = Auth::user(); //this is you active user logged in
        return response()->json($user, 200);
    }


    public function update(Request $request) {  // update user information
        $user = Auth::user();           
        $this->validate($request, [
            'phone' => 'digits_between:10,12',
        ]);
        $userpro = User::find($user->id);
        if($userpro){
            $userpro->update([
                'phone' => $request->input('phone'),
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'username' => $request->input('username'),
                ]);
        return response()->json($user, 200);
        }else{
            $res['message'] = 'can not update this time!';
            return response()->json($res, 403);
        }
    }

        public function update_employee_profile(Request $request)
        {
            $this->validateRequest($request);
        
                $user = auth()->user();
            //start temporay transaction
            $employee_profile = Employee::updateOrCreate(
                [
                'user_id'   => Auth::user()->id,
                ],
                [
                'user_id' => $user->id,
                'employer_code' => $request->input('employer_code'),
                'employer_name' => $request->input('employer_name'),
                'nok_fname' => $request->input('nok_fname'),
                'nok_lname' => $request->input('nok_lname'),
                'nok_email'    => $request->input('nok_email'),
                'nok_address'    => $request->input('nok_address'),
                'nok_phone'    => $request->input('nok_phone'),
                // 'nok_relationship' => $request->input('nok_relationship'),
                'profile_status' => '1',
                ]);

                if($employee_profile){
                    $msg['message'] = 'Profile updated successfully';
                    $msg['status'] = 201;
                    return $msg;
            }else {
                $res['message'] = 'can not update this at this time!';
                return response()->json($res, 403);
            }
        }


        public function validateRequest(Request $request){
            $rules = [
                'nok_email'    => 'sometimes|email|',
                'nok_phone'    => 'required|digits_between:10,12',
                'nok_fname'    => 'required|string',
            ];
            $messages = [
                'required' => ':attribute is required',
                'email'    => ':attribute not a valid format',
            ];
        $this->validate($request, $rules, $messages);
    }
}
