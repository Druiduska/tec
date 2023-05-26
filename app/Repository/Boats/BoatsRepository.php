<?php

declare(strict_types=1);

namespace App\Repository\Boats;

//use Illuminate\Support\Str;

use App\Models\Boats;

class BoatsRepository
{
    public function __construct()
    {
    }

    /**
     * @param array $data
     * @return string
     */
    public function create(
        array $data
    ): string
    {

        $boat = Boats::create($data);
        return (string)$boat->id;
    }

    /**
     * @param string $boat_id
     * @return mixed
     */
    public function getBoat(string $boat_id)
    {
        return Boats::where('id', $boat_id)->first();
    }

    /**
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(
        string $id,
        array  $data
    )
    {
        return Boats::where('id', $id)->first()->update($data);
    }
}
/*'id' => Str::uuid(),*/
