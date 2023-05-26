<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoatsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected array $data_list = [
        ['id' => 1, 'name' => 'Парусная яхта'],
        ['id' => 2, 'name' => 'Катамаран'],
        ['id' => 3, 'name' => 'Плавучий дом'],
        ['id' => 4, 'name' => 'Моторная лодка'],
        ['id' => 5, 'name' => 'Моторная яхта'],
        ['id' => 6, 'name' => 'Гулет'],
        ['id' => 7, 'name' => 'Мощный катамаран'],
        ['id' => 8, 'name' => 'Глиссирующие яхты с флайбриджем'],
        ['id' => 9, 'name' => 'Закрытые круизные яхты с хардтопом'],
        ['id' => 10, 'name' => 'Открытые круизные яхты'],
        ['id' => 32767, 'name' => 'Другое'],
    ];

    public function run()
    {
        foreach ($this->data_list as $item)
        DB::table('boats.boats_types')->insert([
            'id' => $item['id'],
            'name'=> $item['name'],
        ]);
    }

}
