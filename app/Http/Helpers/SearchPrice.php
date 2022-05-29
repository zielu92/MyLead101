<?php
namespace App\Http\Helpers;

use App\Models\Price;
use Illuminate\Http\Request;

class SearchPrice
{
    public static function apply(Request $filters)
    {
        $filterableLike = ['name'];
        $filterableStrict = ['price', 'products_id'];
        $price = (new Price())->newQuery();

        // filter out everything "like"
        foreach($filterableLike as $parameter) {
            if ($filters->has($parameter)) {
                $price->where($parameter, 'like', '%'. $filters->input($parameter). '%');
            }
        }
        // filter out strictly
        foreach($filterableStrict as $parameter) {
            if ($filters->has($parameter)) {
                $price->where($parameter,  $filters->input($parameter));
            }
        }

        //sorting
        if($filters->has('sortBy')){
            $price->orderBy($filters->get('sortBy'), $filters->get('direction', 'ASC'));
        }

        return $price->get();
    }
}
