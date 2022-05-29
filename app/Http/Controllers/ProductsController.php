<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SearchProducts;
use App\Models\Price;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        return response()->json(SearchProducts::apply($request),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $requestData['user_id'] = Auth::user()->id;
        $productId = Products::create($requestData)->id;

        foreach($requestData['price'] as $price) {
            $price['products_id'] = $productId;
            Price::create($price);
        }
        return response()->json(['message'=>'product has been added', 'status' => true],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Products::with('price')->where('id', $id)->get()->first();
        if ($product === null) {
            return response()->json(['message'=>'product do not exists', 'status' => false],404);
        }
        return response()->json($product,200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $product = Products::find($id);
        if ($product === null) {
            return response()->json(['message'=>'product do not exists', 'status' => false],404);
        }
        $product->update($requestData);
        return response()->json(['message'=>'product has been updated', 'status' => true],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Products::find($id);
        if ($product === null) {
            return response()->json(['message'=>'product do not exists', 'status' => false],404);
        }
        $product->delete();
        Price::where('products_id', $id)->delete();
        return response()->json(['message'=>'product has been removed', 'status' => true],200);
    }
}
