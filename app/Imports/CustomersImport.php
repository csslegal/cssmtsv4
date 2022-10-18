<?php

namespace App\Imports;

use App\Models\Customers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rowIndex = 0;
        foreach ($rows as $row) {
            if ($rowIndex == 0) {
                $rowIndex++;
                continue;
            }
            if (
                DB::table('customers')->where('tc_number', '=', $row[1])->count() == 0 ||
                (Customers::where('name', '=', $row[0])->where('phone', '=', $row[3])->count() == 0 &&
                    Customers::where('name', '=', $row[0])->where('email', '=', $row[4])->count() == 0 )
            ) {

                Customers::create([
                    'name' => $row[0],
                    'tc_number' => $row[1],
                    'address' => $row[2],
                    'phone' => $row[3],
                    'email' => $row[4],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
