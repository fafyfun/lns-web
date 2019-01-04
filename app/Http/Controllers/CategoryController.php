<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\ActivityRepository\NormalActivity;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {

        $collectionId = [];

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "productDataActive"=>"active",
            "productDataIn" =>"in",
            "categoryActive" =>"active",
            "categoryIn" =>"in",
            "manageCategoryActive" =>"active"
        ];


        $categories = Category::paginate(10);

        // dd($roles->toArray()['data']);

        if($categories->count() > 0){

            $collectionId=$categories->pluck('id');

        }

        //$collectionId = collect($allId);

        return view('categories.show',compact(['categories','collectionId','classItems']));
    }

    public function create()
    {

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "productDataActive"=>"active",
            "productDataIn" =>"in",
            "categoryActive" =>"active",
            "categoryIn" =>"in",
            "createCategoryActive" =>"active"
        ];

        return view('categories.create',compact(['classItems']));
    }

    public function store(Request $request, Category $category,NormalActivity $normalActivity)
    {
        $this->validate($request,[
            'name' => 'required|unique:categories',

        ]);

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $name = $request->get('name');

        $description = $request->get('description');

        $category->name = $name;

        $category->description = $description;

        if($category->isDirty()){

            $msgAndStatus = [
                "success" => "Inserted"
            ];
        }

        try{
            $category->save();


        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($category->id,"created_category",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("categories")->with($msgAndStatus);
    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){

        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );

        return $sujectMatters;

    }

    public function edit($id){

        $category = Category::findOrFail($id);

        return view('categories.edit',compact(['category']));
    }

    public function update(Request $request,NormalActivity $normalActivity,$id){

        $this->validate($request,[
            'name' => 'required',
        ]);

        $msgAndStatus = [
            "error" => "Not Updated"
        ];


        $name = trim($request->get('name'));

        $description = trim($request->get('description'));

        $category = Category::find($id);

        $category->name = $name;

        $category->description = $description;

        if($category->isDirty()){

            $msgAndStatus = [
                "success" => "Updated"
            ];

        }

        try{
            $category->save();

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($id,"updated_category",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("categories")->with($msgAndStatus);


    }

    public function destroy(Request $request,NormalActivity $normalActivity){


        $deletedCategories=[];

        $categoryId = $request->get('deleteCategory');

        foreach($categoryId as $id){

            $category=Category::find($id);

            $deletedCategories[$id]=$category->name;
        }

        try{

            $deleted=Category::destroy($categoryId);

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];

            if ($error_code) {

                $response = $this->setDeleteResponse(0,$e->errorInfo[2]);

                return response()->json($response);


            }

        }


        if($deleted >= 1){

            $response=$this->setDeleteResponse(1,"Deleted");

            $this->loopThroughDeletedRoles($categoryId,$deletedCategories,$normalActivity);

            return response()->json($response);

        }
        $response = $this->setDeleteResponse(0,"Not Deleted");

        return response()->json($response);
    }

    public function setDeleteResponse($status,$msg){

        $response = [
            'status' => $status,
            'msg' => $msg

        ];

        return $response;
    }

    public function loopThroughDeletedRoles($categoryId,$deletedCategories,NormalActivity $normalActivity){

        foreach($categoryId as $id){

            $sujectMatters=$this->setAndGetSubjectMatters($id,"deleted_category",$deletedCategories[$id]);

            $normalActivity->updateActivity($sujectMatters);
        }


    }
}
