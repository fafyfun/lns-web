<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use App\ActivityRepository\NormalActivity;


class BrandController extends Controller
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
            "brandActive" =>"active",
            "brandIn" =>"in",
            "manageBrandActive" =>"active"
        ];


        $brands = Brand::paginate(10);

        // dd($roles->toArray()['data']);

        if($brands->count() > 0){

            $collectionId=$brands->pluck('id');

        }

        //$collectionId = collect($allId);

        return view('brands.show',compact(['brands','collectionId','classItems']));
    }

    public function create()
    {

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "productDataActive"=>"active",
            "productDataIn" =>"in",
            "brandActive" =>"active",
            "brandIn" =>"in",
            "createBrandActive" =>"active"
        ];

        return view('brands.create',compact(['classItems']));
    }

    public function store(Request $request, Brand $brand,NormalActivity $normalActivity)
    {
        $this->validate($request,[
            'name' => 'required|unique:brands',

        ]);

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $name = $request->get('name');

        $description = $request->get('description');

        $brand->name = $name;

        $brand->description = $description;

        if($brand->isDirty()){

            $msgAndStatus = [
                "success" => "Inserted"
            ];
        }

        try{
            $brand->save();


        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($brand->id,"created_brand",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("brands")->with($msgAndStatus);
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

        $brand = Brand::findOrFail($id);

        return view('brands.edit',compact(['brand']));
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

        $brand = Brand::find($id);

        $brand->name = $name;

        $brand->description = $description;

        if($brand->isDirty()){

            $msgAndStatus = [
                "success" => "Updated"
            ];

        }

        try{
            $brand->save();

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($id,"updated_brand",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("brands")->with($msgAndStatus);


    }

    public function destroy(Request $request,NormalActivity $normalActivity){


        $deletedBrands=[];

        $brandId = $request->get('deleteBrand');

        foreach($brandId as $id){

            $brand=Brand::find($id);

            $deletedBrands[$id]=$brand->name;
        }

        try{

            $deleted=Brand::destroy($brandId);

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];

            if ($error_code) {

                $response = $this->setDeleteResponse(0,$e->errorInfo[2]);

                return response()->json($response);


            }

        }


        if($deleted >= 1){

            $response=$this->setDeleteResponse(1,"Deleted");

            $this->loopThroughDeletedRoles($brandId,$deletedBrands,$normalActivity);

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

    public function loopThroughDeletedRoles($brandId,$deletedBrands,NormalActivity $normalActivity){

        foreach($brandId as $id){

            $sujectMatters=$this->setAndGetSubjectMatters($id,"deleted_brand",$deletedBrands[$id]);

            $normalActivity->updateActivity($sujectMatters);
        }


    }
}
