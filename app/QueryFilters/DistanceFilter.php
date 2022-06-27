<?php

namespace App\QueryFilters;

class DistanceFilter
{
    /**
     * Execute query builder.
     *
     * @return mixed builder
     */
    public function handle($request, $next)
    {
        $builder = $next($request);
        $query = request('distances');

        if (!empty($query)) {
            $builder->whereIn('distance', $query);
        }

        return $builder;
    }
}
