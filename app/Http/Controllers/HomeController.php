<?php

namespace App\Http\Controllers;

use App\QueryFilters\VeggieSuitableFilter;
use App\QueryFilters\CategoryFilter;
use App\QueryFilters\DistanceFilter;
use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\PriceFilter;
use App\QueryFilters\QueryFilter;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $restaurants = $this->getRestaurants();
        return Inertia::render('Home', [
            'categories' => $categories,
            'restaurants' => $restaurants
        ]);
    }

    private function getRestaurants()
    {
        return app(Pipeline::class)->send(Restaurant::query())
            ->through([
                CategoryFilter::class,
                DistanceFilter::class,
                PriceFilter::class,
                QueryFilter::class,
                VeggieSuitableFilter::class
            ])
            ->thenReturn()
            ->with([
                'address', 'category'
            ])->get();
    }
}
