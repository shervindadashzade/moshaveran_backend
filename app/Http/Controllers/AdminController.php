<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Admin;

class AdminController extends Controller
{
    public function validator(array $data){
        return Validator::make($data,[
            'email' => 'required',
            'password' => 'required',
        ]);
    }
    
    public function login(Request $request){
        $validator = $this->validator($request->all());
        
        if($validator->fails()){
            return response()->json([
                'message' => 'invalid form of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $admin = Admin::where(['email'=>$request->email])->first();

        if($admin == null){
            return response()->json([
                'message' => 'no email founded'
            ],403);//TODO::check code
        }else{
            if(Hash::check($request->password,$admin->password)){
                $admin->api_token = Str::random(60);
                $admin->save();
                return $admin;
            }else{
                return response()->json([
                    'message' => 'wrong password'
                ],403);
            }
        }
    }

    public function logout(Request $request){
        return $request->user;
    }
}
