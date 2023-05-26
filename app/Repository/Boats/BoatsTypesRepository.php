<?php

declare( strict_types=1 );

namespace App\Repository\Boats;

//use Illuminate\Support\Str;

use App\Models\BoatsTypes;


class BoatsTypesRepository
{
    public function __construct()
    {
    }

    /**
     * @param int $id
     * @param string $name
     * @return int
     */
    public function create(
        int    $id,
        string $name
    ): int
    {
        $BoatsType = BoatsTypes::create(['id' => $id, 'name' => $name]);
        return (int)$BoatsType->id;
    }

    /**
     * @return mixed
     */
    public function getBoatsTypeList()
    {
        return BoatsTypes::all(['id', 'name']);
    }
}
