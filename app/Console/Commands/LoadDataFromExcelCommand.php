<?php

namespace App\Console\Commands;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use App\Imports\ExcelImport;
use Illuminate\Support\Str;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Address;

class LoadDataFromExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load:excel-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will load data from restaurant excel and store it in to db';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $import = $this->getDataFromExcel();
        if (!empty($import->data)) {
            $this->storeData($import->data);
        } else {
            $this->error("Could't load data from Essensziele.xlsx");
        }

        return 0;
    }

    private function getDataFromExcel()
    {
        $filePath = public_path('Essensziele.xlsx');
        $import = new ExcelImport();
        Excel::import($import, $filePath);
        return $import;
    }

    private function storeData($data)
    {
        try {
            DB::beginTransaction();
            $categories = $this->storeCategories($data);
            $this->storeRestaurants($data, $categories);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }

    private function storeCategories($data)
    {
        $categories = $data->pluck('Kategorie');
        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category)],
                ['name' => $category]);
        }

        return Category::whereIn('name', $categories->toArray())->get()->keyBy('name');

    }

    private function storeRestaurants($data, $categories)
    {
        foreach ($data as $item) {
            $restaurant = Restaurant::updateOrCreate([
                'slug' => Str::slug($item['Name'])
            ], [
                'name' => $item['Name'],
                'category_id' => $categories->get($item['Kategorie'])->id,
                'price' => $item['Preis'],
                'distance' => $item['Entfernung'],
                'veggie_suitable' => $item['Veggie-Tauglich']
            ]);
            Address::firstOrCreate(['restaurant_id' => $restaurant->id], ['label' => $item['Adresse']]);
        }
    }
}
