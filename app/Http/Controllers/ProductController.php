<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;
use App\ActivityRepository\NormalActivity;
use Illuminate\Filesystem\Filesystem as File;


class ProductController extends Controller
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
            "productActive" =>"active",
            "productIn" =>"in",
            "manageProductActive" =>"active"
        ];


        $products = Product::paginate(10);


        // dd($roles->toArray()['data']);

        if($products->count() > 0){

            $collectionId=$products->pluck('id');

        }

        //$collectionId = collect($allId);

        return view('products.show',compact(['products','collectionId','classItems']));
    }

    public function create()
    {

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "productDataActive"=>"active",
            "productDataIn" =>"in",
            "productActive" =>"active",
            "productIn" =>"in",
            "createProductActive" =>"active"
        ];

        $brands = Brand::select('id','name')->get();
        $categories = Category::select('id','name')->get();


        return view('products.create',compact(['classItems','brands','categories']));
    }

    public function store(Request $request, Product $product,NormalActivity $normalActivity)
    {

        //dd('in');
        $this->validate($request,[
            'name' => 'required|unique:products',
            'category' => 'required',
            'brand' => 'required',
            'published' => 'required',
            'uom' => 'required',
            'unitprice' => 'required',
            'image' => 'required | mimes:jpeg,jpg,png'

        ]);

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $name = $request->get('name');
        $description = $request->get('description');
        $categoryId = $request->get('category');
        $brandId = $request->get('brand');
        $published = $request->get('published');
        $uom = $request->get('uom');
        $unitPrice = $request->get('unitprice');
        $image = $request->file('image');

        //dd($image);

        $product->name = $name;
        $product->description = $description;
        $product->category_id = $categoryId;
        $product->brand_id = $brandId;
        $product->published = $published;
        $product->uom = $uom;
        $product->unit_price = $unitPrice;
        $extension = strtolower($image->getClientOriginalExtension());
        $product->image = str_replace(' ', '', $name).".".$extension;

        $extension = strtolower($image->getClientOriginalExtension());



        if($product->isDirty()){

            //dd('in');

            $msgAndStatus = [
                "success" => "Inserted"
            ];
        }

        try{
            $product->save();

            $image->move(public_path().'/images/products', str_replace(' ', '', $name).'.'.$extension);


        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($product->id,"created_product",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("products")->with($msgAndStatus);
    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){

        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );

        return $sujectMatters;

    }

    public function detail($id){

        $product = Product::with('brand','category')->find($id);

        return view('products.detail',compact(['product']));

    }

    public function edit($id){

        $product = Product::find($id);

        $categories = Category::select('id','name')->get();
        $brands = Brand::select('id','name')->get();

        return view('products.edit',compact(['product','categories','brands']));
    }

    public function update(Request $request,NormalActivity $normalActivity,$id,File $file){

        $this->validate($request,[
            'name' => 'required',
            'category' => 'required',
            'brand' => 'required',
            'published' => 'required',
            'uom' => 'required',
            'unitprice' => 'required',
        ]);



        if($request->file('image') != null){

            $this->validate($request,[
                'image' => 'required | mimes:jpeg,jpg,png'
            ]);

            $image = $request->file('image');
            $extension = strtolower($image->getClientOriginalExtension());

        }



        $msgAndStatus = [
            "error" => "Not Updated"
        ];


        $name = trim($request->get('name'));
        $description = trim($request->get('description'));
        $categoryId = $request->get('category');
        $brandId = $request->get('brand');
        $published = $request->get('published');
        $uom = $request->get('uom');
        $unitPrice = $request->get('unitprice');

        $product = Product::find($id);

        $exsitingImage = $product->image;

        $product->name = $name;
        $product->description = $description;
        $product->category_id = $categoryId;
        $product->brand_id = $brandId;
        $product->published = $published;
        $product->uom = $uom;
        $product->unit_price = $unitPrice;

        if($request->file('image')!=null){

            $product->image = str_replace(' ', '', $name).'.'.$extension;
        }

        if($product->isDirty()){

            $msgAndStatus = [
                "success" => "Updated"
            ];

        }

        try{
            $product->save();

            if($request->file('image')!=null){

                if($file->exists(public_path().'/images/products/'.$exsitingImage)){

                    $file->delete(public_path().'/images/products/'.$exsitingImage);
                }

                $request->file('image')->move(public_path().'/images/products', str_replace(' ', '', $name).'.'.$extension);
                $msgAndStatus = [
                    "success" => "Updated"
                ];
            }



        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($id,"updated_product",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("products")->with($msgAndStatus);


    }

    public function destroy(Request $request,NormalActivity $normalActivity,File $file){


        $productId = $request->get('deleteProduct');
        $deletedCount = 0;

        foreach($productId as $id){

            $product=Product::find($id);
            $exsitingImage = $product->image;

            try{

                $deleted=Product::destroy($id);

                if($deleted >= 1){

                    if($file->exists(public_path().'/images/products/'.$exsitingImage)){

                        $file->delete(public_path().'/images/products/'.$exsitingImage);
                    }

                    $sujectMatters=$this->setAndGetSubjectMatters($id,"deleted_product",$product->name);
                    $normalActivity->updateActivity($sujectMatters);
                    $deletedCount++;

                }

            }catch(\Illuminate\Database\QueryException $e){

                $error_code = $e->errorInfo[1];

                if ($error_code) {

                    $response = $this->setDeleteResponse(0,$e->errorInfo[2]."<br>".$deletedCount." Deleted");
                    return response()->json($response);


                }

            }



        }




        if($deletedCount > 0){

            $response=$this->setDeleteResponse(1,$deletedCount." Deleted");

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



}
