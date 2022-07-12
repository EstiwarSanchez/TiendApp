<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            [
                'name' => 'S',
                'description' => 'Talla pequeña',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'M',
                'description' => 'Talla mediana',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'L',
                'description' => 'Talla grande',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
