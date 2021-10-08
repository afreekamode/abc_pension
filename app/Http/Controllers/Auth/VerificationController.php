<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
      //generate new password for the user
    public function generatedPassword()
    {
        return substr(md5(time()), 0, 6);
    }

    public function verify($verifycode, $email) {

        $checkCode = User::where('verifycode', $verifycode)
        ->where('email', $email)
        ->exists();

        if ($checkCode) {

        $user = User::where('verifycode', $verifycode)->get()->first();
            if($user->role == 1){
                $prefix = 'EMP';
            }elseif($user->role == 2){
                $prefix = 'EEM';
            }
            
            $pensionPrefix = $prefix.$this->generatePin();

            $token = $user->createToken('authToken')->accessToken;
        
            if ($user->email_verified_at == null){
                //generate a new verify code 
                $user->verifycode = $this->generatedPassword();
                $user->email_verified_at = now();
                $user->pen_code = $pensionPrefix;
                $user->save();
                
                $msg["message"] = "Account is verified. You can now login.";
                $msg['verified'] = "True";
                $msg['Accesstoken'] = $token;
                $msg['pension_code'] = $pensionPrefix;
                $msg['image_link'] = 'https://res.cloudinary.com/getfiledata/image/upload/';
                $msg['image_format'] = 'w_200,c_thumb,ar_4:4,g_face/';

                return response()->json($msg, 200);
                
            } else {
                $msg["message"] = "Account verified already. Please Login";
                $msg['note'] = 'please redirect to login page';
                $msg['verified'] = "Done";

                return response()->json($msg, 208);
             }

        } else{
            $msg["message"] = "Account with code does not exist!";

            return response()->json($msg, 404);

        }  
        
    }

    public function generatePin() {
        // Available alpha caracters
        $characters = '0000000000000';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(100000, 999999)
            . mt_rand(10000, 99999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        return $string;
    }
}
