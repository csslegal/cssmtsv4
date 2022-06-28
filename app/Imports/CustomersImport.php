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
        foreach ($rows as $row) {

            if (
                DB::table('customers')->where('tcno', '=', $row[1])->count() == 0
                || (Customers::where('name', '=', $row[0])->where('telefon', '=', $row[3])->count() == 0
                    &&  Customers::where('name', '=', $row[0])->where('email', '=', $row[4])->count() == 0
                )
            ) {

                Customers::create([
                    'name' => $row[0],
                    'tcno' => $row[1],
                    'adres' => $row[2],
                    'telefon' => $row[3],
                    'email' => $row[4],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
