<?php

namespace App\QueryFilters;

class VeggieSuitableFilter
{
    /**
     * Execute query builder.
     *
     * @return mixed builder
     */
    public function handle($request, $next)
    {
        $builder = $next($request);
        $query = request('veggie_suitables');

        if (!empty($query)) {
            $builder->whereIn('veggie_suitable', $query);
        }

        return $builder;
    }
}
