<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\VerifyPhone;
use App\User;
use App\Counselor;

class VerifyPhoneController extends Controller
{
    //TODO::add timer for delete code

    public function validator(array $data){
        return Validator::make($data,[
            'phone' => 'required|numeric',
            'code' => 'numeric',
        ]);
    }


    public function generateCode($length){
        $characters = '123456789';
        $code = '';
        for($i=0;$i<$length;$i++){
            $code .= $characters[rand(0, strlen($characters)-1)];
        }
        return $code;
    }


    public function send_sms(Request $request){
        $validator = $this->validator($request->all());

        // check validator if fails
        if($validator->fails()){
            return response()->json([
                'message' => 'invalid form of data',
                'errors' => $validator->errors()->all()
            ],400);
        }
        if(strlen($request->phone) != 11)
            return response()->json([
                'message' => 'length of phone number should be 11'
            ],400);
        //generate code
        $code = $this->generateCode(6);
        
        $record = VerifyPhone::firstOrNew(array('phone'=>$request->phone));
        $record->code = $code;
        $record->save();
        //TODO::method for send sms to user

        return response()->json([
            'message' => 'code has been sended via sms.'
        ],200);
    }

    
    public function verify_sms(Request $request){
        $validator = $this->validator($request->all());

        // check validator if fails
        if($validator->fails()){
            return response()->json([
                'message' => 'invalid form of data.',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $record = VerifyPhone::where('phone','=',$request->phone)->first();

        // check if number registered
        if($record == null){
            return response()->json([
                'message' => 'this phone number not registered yet.'
            ],401);
        }else{
            //check if code is valid
            if($request->code == $record->code){
                $record->delete();
                // sign up user or create a api code for user and send informations
                //$request->user_type == {
                //  USER,COUNSELOR
                //}
                if($request->user_type == 'USER'){
                    $user = User::firstOrNew(array( 'phone'=>$request->phone ));
                    $api_token = Str::random(60);
                    $user->api_token = $api_token;
                    $user->save();
                    return $user;
                }
                if($request->user_type == 'COUNSELOR'){
                    $user = Counselor::firstOrNew(array('phone'=>$request->phone));
                    $api_token = Str::random(60);
                    $user->api_token = $api_token;
                    $user->save();
                    return $user;
                }
            }else{
                return response()->json([
                    'message' => 'incorrect code'
                ],400);
            }
        }
        
    }

}