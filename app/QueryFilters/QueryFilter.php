<?php

namespace App\QueryFilters;

class QueryFilter
{
    /**
     * Execute query builder.
     *
     * @return mixed builder
     */
    public function handle($request, $next)
    {
        $builder = $next($request);

        if (request()->filled('query')) {
            return $builder->where(function ($query) {
                $query->where('restaurants.name', 'LIKE', '%' . request('query') . '%')
                    ->orWhere('restaurants.slug', 'LIKE', '%' . request('query') . '%');
            });
        }

        return $builder;
    }
}
