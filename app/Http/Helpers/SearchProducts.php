<?php
namespace App\Http\Helpers;

use App\Models\Products;
use Illuminate\Http\Request;

class SearchProducts
{
    public static function apply(Request $filters)
    {
        $filterableLike = ['name', 'description', 'sku'];
        $products = (new Products())->newQuery();

        // filter out everything "like"
        foreach($filterableLike as $parameter) {
            if ($filters->has($parameter)) {
                $products->where($parameter, 'like', '%'. $filters->input($parameter). '%');
            }
        }

        // strictly filter out user_id
        if ($filters->has('user_id')) {
            $products->where('user_id', $filters->input('user_id'));
        }

        //sorting
        if($filters->has('sortBy')){
            $products->orderBy($filters->get('sortBy'), $filters->get('direction', 'ASC'));
        }

        //TODO: consider pagination
        return $products->with('price')->get();
    }
}
