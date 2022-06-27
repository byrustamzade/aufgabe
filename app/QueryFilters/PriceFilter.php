<?php

namespace App\QueryFilters;

class PriceFilter
{
    /**
     * Execute query builder.
     *
     * @return mixed builder
     */
    public function handle($request, $next)
    {
        $builder = $next($request);
        $query = request('prices');

        if (!empty($query)) {
            $builder->whereIn('price', $query);
        }

        return $builder;
    }
}
