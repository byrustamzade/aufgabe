<?php

namespace App\QueryFilters;

class CategoryFilter
{
    /**
     * Execute query builder.
     *
     * @return mixed builder
     */
    public function handle($request, $next)
    {
        $builder = $next($request);
        $query = request('categories');

        if (!empty($query)) {
            $builder->whereHas('category', function ($q) use ($query) {
                $q->whereIn('slug', $query);
            });
        }

        return $builder;
    }
}
