<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImport implements ToCollection
{
    public $data;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $collection = collect();
        $keys = [];
        foreach ($rows as $key => $row) {
            $rowData = $row->toArray();
            if (!empty(array_filter($rowData))) {
                if ($key === 1) {
                    $keys = $rowData;
                } else {
                    $collection->push(array_combine($keys, $rowData));
                }
            }
        }
        $this->data = $collection;
    }
}
