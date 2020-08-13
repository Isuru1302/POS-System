<?php


namespace App\Http\Controllers;
use App\categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function newCategory(Request $request){
        $category = new categories();
        $category->Name = $request->input("Name");
        $category->status = 1;
        $category->save();
    }

    public function getCategories(){
        $categories = categories::orderByRaw("status desc,id desc")->get();
        return response()->json(['categories'=>$categories],201);
    }

    public function getCategoryById($id){
        $category = categories::find($id);
        return response()->json(['category'=>$category],201);
    }

    public function deleteCategory($id){
        $category = categories::find($id);
        if($category->status===0){
            $category->status = 1;
        }else{
            $category->status = 0;
        }

        $category->save();
    }

    public function updateCategory(Request $request,$id){
        $category = categories::find($id);
        $category->Name = $request->input("Name");
        $category->save();
    }

}
