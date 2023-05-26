<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShipyardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected array $data_list = [
        ['id' => 1, 'name' => 'Absolute'],
        ['id' => 2, 'name' => 'Azimut'],
        ['id' => 3, 'name' => 'Bavaria'],
        ['id' => 4, 'name' => 'Beneteau'],
        ['id' => 5, 'name' => 'Chaparral'],
        ['id' => 6, 'name' => 'Chris-Craft'],
        ['id' => 7, 'name' => 'Contest Yachts'],
        ['id' => 8, 'name' => 'Crownline'],
        ['id' => 9, 'name' => 'Discovery'],
        ['id' => 10, 'name' => 'Dufour'],
        ['id' => 11, 'name' => 'Dynamiq'],
        ['id' => 12, 'name' => 'Fairline'],
        ['id' => 13, 'name' => 'Ferretti'],
        ['id' => 14, 'name' => 'Finnmaster'],
        ['id' => 15, 'name' => 'Fountaine Pajot'],
        ['id' => 16, 'name' => 'Four Winns'],
        ['id' => 17, 'name' => 'Galeon'],
        ['id' => 18, 'name' => 'Grand Soleil'],
        ['id' => 19, 'name' => 'Greenline'],
        ['id' => 20, 'name' => 'Hallberg-Rassy'],
        ['id' => 21, 'name' => 'Hanse'],
        ['id' => 22, 'name' => 'Jeanneau'],
        ['id' => 23, 'name' => 'Lagoon'],
        ['id' => 24, 'name' => 'Leopard'],
        ['id' => 25, 'name' => 'Mastercraft'],
        ['id' => 26, 'name' => 'Monterey'],
        ['id' => 27, 'name' => "Nautor's Swan"],
        ['id' => 28, 'name' => 'Nimbus'],
        ['id' => 29, 'name' => 'NorthSilver'],
        ['id' => 30, 'name' => 'Pearl'],
        ['id' => 31, 'name' => 'Pershing'],
        ['id' => 32, 'name' => 'Prestige'],
        ['id' => 33, 'name' => 'Princess'],
        ['id' => 34, 'name' => 'Regal'],
        ['id' => 35, 'name' => 'Riva'],
        ['id' => 36, 'name' => 'Sanlorenzo'],
        ['id' => 37, 'name' => 'Sea Ray'],
        ['id' => 38, 'name' => 'Shipman'],
        ['id' => 39, 'name' => 'Solaris'],
        ['id' => 40, 'name' => 'Southerly'],
        ['id' => 41, 'name' => 'Sunseeker'],
        ['id' => 42, 'name' => 'Velvette'],
        ['id' => 43, 'name' => 'Wauquiez Boats'],
        ['id' => 44, 'name' => 'Wim van der Valk'],
        ['id' => 2147483647, 'name' => 'Другое'],
    ];

    public function run()
    {
        foreach ($this->data_list as $item)
            DB::table('boats.shipyards')->insert([
                'id' => $item['id'],
                'name' => $item['name'],
            ]);
    }

}

?>


