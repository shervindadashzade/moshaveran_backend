<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Category;
use App\SubCategory;

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

    public function editCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'cat_id' => 'required | numeric',
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
                'message' => 'category not founded'
            ],404);
        }else{
            $cat->update($request->all());
            return $cat;
        }
    }

    public function editSubCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'subcat_id' => 'required | numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'invalid forms of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $cat = SubCategory::find($request->subcat_id);
        if($cat == null){
            return response()->json([
                'message' => 'subcategory not founded'
            ],404);
        }else{
            $cat->update($request->all());
            return $cat;
        }
    }
    
    public function deleteCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'cat_id' => 'required | numeric',
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
                'message' => 'category not founded'
            ],404);
        }else{
            $cat->subCategories()->delete();
            $cat->delete();
            return response()->json([
                'message' => 'category successfully removed'
            ],200);
        }
    }

    public function deleteSubCategory(Request $request){
        $validator = Validator::make($request->all(),[
            'subcat_id' => 'required | numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'invalid forms of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $cat = SubCategory::find($request->subcat_id);
        if($cat == null){
            return response()->json([
                'message' => 'subcategory not founded'
            ],404);
        }else{
            $cat->delete();
            return response()->json([
                'message' => 'subcategory successfully removed'
            ],200);
        }
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

    public function indexCounselors(Request $request){
        $validator = Validator::make($request->all(),[
            'subcat_id' => 'required | numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'invalid forms of data',
                'errors' => $validator->errors()->all()
            ],400);
        }

        $subCat = SubCategory::find($request->subcat_id);
        if($subCat == null){
            return response()->json([
                'message' => 'no subcategry founded'
            ],400); 
        }else{
            return $subCat->counselors()->get();
        }
    }
}
