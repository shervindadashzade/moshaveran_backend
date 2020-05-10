<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CounselorController extends Controller
{
    public function complete(Request $request){
        if($request->user->fname != null)
            return response()->json([
                'message' => 'counselor data is completed'
            ],400);
        $validator = Validator::make($request->all(),[
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required | email',
            'photo' => 'required',
            // form of categories => [2,5,6,8,1,...]
            'categories' => 'required',
            'cv' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'invalid forms of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $categories = preg_split("/[,]/",$request->categories);

        $user = $request->user;
        
        foreach($categories as $cat){
            $user->subCategories()->attach((int)$cat);
        }

        $user->update($request->all());

        return $user;
    }

}
