<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('suppliers')->insert([
            ['name' => 'Supplier 1'],
            ['name' => 'Supplier 2'],
            ['name' => 'Supplier 3'],
        ]);
    }
}
