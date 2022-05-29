<?php

namespace App\Http\Controllers;

use App\Http\Helpers\SearchPrice;
use App\Models\Price;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
{
    public function getPrices(Request $request) {
        return response()->json(SearchPrice::apply($request),200);
    }

    public function store(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required',
            'price' => 'required',
            'products_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $product = Products::with('price')->where('id', $requestData['products_id'])->get()->first();
        if ($product === null) {
            return response()->json(['message'=>'product with this ID do not exists', 'status' => false],404);
        }
        Price::create($requestData);

        return response()->json(['message'=>'price has been added', 'status' => true],201);
    }

    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData,[
            'name' => 'required',
            'price' => 'required||numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $product = Products::with('price')->where('id', $requestData['products_id'])->get()->first();
        if ($product === null) {
            return response()->json(['message'=>'product with this ID do not exists', 'status' => false],404);
        }
        $price = Price::find($id);
        if ($price === null) {
            return response()->json(['message'=>'price do not exists', 'status' => false],404);
        }
        $price->update($requestData);
        return response()->json(['message'=>'price has been updated', 'status' => true],200);
    }
    public function destroy($id)
    {
        $price = Price::find($id);
        if ($price === null) {
            return response()->json(['message'=>'price do not exists', 'status' => false],404);
        }
        $price->delete();
        return response()->json(['message'=>'price has been removed', 'status' => true],200);
    }
}
