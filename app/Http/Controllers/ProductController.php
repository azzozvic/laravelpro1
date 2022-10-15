<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Product as ProductResource;
class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products=Product::all();
       return $this->sendResponse( ProductResource::collection( $products),'all product send');
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validator=Validator::make( $input,[

            'name'=>'required',
            'detail'=>'required ',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendErorr('please validate',$validator->errors());
         }
         $product=Product::create( $input);
         return $this->sendResponse( new ProductResource( $product),'product created successfuly');
    }

    public function show( $id)
    {
        $product=Product::create($id);
        if (is_null($product)) {
            return $this->sendErorr('your product not found');
         }
         return $this->sendResponse( new ProductResource( $product),'product found successfuly');

    }

    public function update(Request $request, Product $product)
    {
        $input=$request->all();
        $validator=validator::make( $input,[
            'name'=>'required',
            'detail'=>'required ',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->sendErorr('please validate',$validator->errors());
         }
         $product->name=$input['name'];
         $product->detail=$input['detail'];
         $product->price=$input['price'];
         $product->save();
         return $this->sendResponse( new ProductResource( $product),'product updated successfuly');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->sendResponse( new ProductResource( $product),'product deleted successfuly');

    }
}
