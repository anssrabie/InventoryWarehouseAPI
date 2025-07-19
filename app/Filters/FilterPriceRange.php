<?php

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;


class FilterPriceRange implements Filter
{
    public function __invoke(Builder $query, $value, $property)
    {
        $operator = '>=';
        if($property === 'price_to'){
            $operator = '<=';
        }
        $property = 'price';
        $query->where($property,$operator,$value);
    }
}
