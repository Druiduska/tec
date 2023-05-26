<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SailTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected array $data_list = [
        ['id' => 1, 'name' => 'Кэт'],
        ['id' => 2, 'name' => 'Шлюп'],
        ['id' => 3, 'name' => 'Кэч'],
        ['id' => 4, 'name' => 'Иол'],
        ['id' => 5, 'name' => 'Джонка'],
        ['id' => 32767, 'name' => 'Другое'],
    ];

    public function run()
    {
        foreach ($this->data_list as $item)
            DB::table('boats.sail_types')->insert([
                'id' => $item['id'],
                'name' => $item['name'],
            ]);
    }

}

?>


