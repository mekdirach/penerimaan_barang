<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KaratsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('karats')->insert([
            ['parameter_karat' => '24K'],
            ['parameter_karat' => '22K'],
            ['parameter_karat' => '18K'],
        ]);
    }
}
