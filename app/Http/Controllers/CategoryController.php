<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Category;

class CategoryController extends Controller
{
    public function addCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required | unique:categories',
            'icon' => 'required',
            'color' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'invalid forms of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $category = Category::create($request->all());

        return $category;
    }

    
    public function addSubCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'cat_id' => 'required | numeric',
            'title' => 'required | unique:sub_categories',
            'picture' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'invalid forms of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $cat = Category::find($request->cat_id);
        if($cat == null){
            return response()->json([
                'message' => 'Category not founded'
            ],400);
        }

        $sub = $cat->subCategories()->create([
            'title' => $request->title,
            'picture' => $request->picture
        ]);

        return $sub;
    }

    public function index(Request $request){
        $categories = Category::all();
        $response = [];
        foreach($categories as $cat){
            array_push($response,[
                'title' => $cat->title,
                'color' => $cat->color,
                'icon' => $cat->icon,
                'sub' => $cat->subCategories()->get()
            ]);
        }

        return $response;
    }
}
