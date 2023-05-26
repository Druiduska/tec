<?php

declare(strict_types=1);

namespace App\Services\Boats;

use App\Exceptions\DataCreateFail;
use App\Exceptions\DataReciveFail;
use App\Exceptions\DataUpdateFail;
use Illuminate\Database\QueryException;

use App\Repository\Boats\BoatsRepository;
use App\Repository\Boats\BoatsTypesRepository;


class BoatsService
{
    /**
     * @param BoatsRepository $boatsRepository
     * @param BoatsTypesRepository $boatsTypesRepository
     */
    public function __construct(
        protected BoatsRepository      $boatsRepository,
        protected BoatsTypesRepository $boatsTypesRepository
    )
    {
        $this->boatsRepository = $boatsRepository;
    }

    /**
     * @param string|null $id
     * @param $user_id
     * @param $name
     * @param $length
     * @param $beam
     * @param $depth
     * @param $passenger
     * @param $cabins
     * @param $guests_beds
     * @param $bathrooms
     * @param $crew
     * @param $boats_types_id
     * @param $boats_models_id
     * @param $sail_types_id
     * @return string
     * @throws DataCreateFail
     */
    public function create(
        string|null $id = null,
                    $user_id,
                    $name,
                    $length,
                    $beam,
                    $depth,
                    $passenger,
                    $cabins,
                    $guests_beds,
                    $bathrooms,
                    $crew,
                    $boats_types_id,
                    $boats_models_id,
                    $sail_types_id,
    ): string
    {
        $data = $this->inputConversion(
            $user_id,
            $name,
            $length,
            $beam,
            $depth,
            $passenger,
            $cabins,
            $guests_beds,
            $bathrooms,
            $crew,
            $boats_types_id,
            $boats_models_id,
            $sail_types_id,
        );
        if (gettype($id) === 'string') $data['id'] = $id;
        try {
            return $this->boatsRepository->create(
                data: $data
            );
        } catch (QueryException $e) {
            throw new DataCreateFail($e->getMessage(), $e->getCode());
        }
    }

    public function getBoatForMain(string $boat_id) : array
    {
        $boat = $this->boatsRepository->getBoat($boat_id);
        $boats_types = $this->boatsTypesRepository->getBoatsTypeList();
        return [
            'name' => $boat->name,
            'boats_types_id' => $boat->boats_types_id,
            'boats_types' => $boats_types
        ];
    }

    public function getBoat(string $boat_id)
    {
        $boat = $this->boatsRepository->getBoat($boat_id);
        $boat_type = $boat->boatsTypes;
        $sail_types = $boat->sailTypes;
        $boatsModels = $boat->boatsModels;
//        $images = $this->imagesRepository->getImagesList($boat_id);
        $boats_types = $this->boatsTypesRepository->getBoatsTypeList();

        return [
//            'boat' => $boat->name,
            'boat' => $boat,
//            'images' => $images,
            'boats_types' => $boats_types
        ];
    }

    /**
     * @param string $id
     * @param $user_id
     * @param $name
     * @param $length
     * @param $beam
     * @param $depth
     * @param $passenger
     * @param $cabins
     * @param $guests_beds
     * @param $bathrooms
     * @param $crew
     * @param $boats_types_id
     * @param $boats_models_id
     * @param $sail_types_id
     * @return mixed
     * @throws DataUpdateFail
     */
    public function update(
        string $id,
               $user_id,
               $name,
               $length,
               $beam,
               $depth,
               $passenger,
               $cabins,
               $guests_beds,
               $bathrooms,
               $crew,
               $boats_types_id,
               $boats_models_id,
               $sail_types_id,
    )
    {
        $data = $this->inputConversion(
            $user_id,
            $name,
            $length,
            $beam,
            $depth,
            $passenger,
            $cabins,
            $guests_beds,
            $bathrooms,
            $crew,
            $boats_types_id,
            $boats_models_id,
            $sail_types_id,
        );

        try {
            return $this->boatsRepository->update(
                id: $id,
                data: $data
            );
        } catch (QueryException $e) {
            throw new DataUpdateFail($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $user_id
     * @param $name
     * @param $length
     * @param $beam
     * @param $depth
     * @param $passenger
     * @param $cabins
     * @param $guests_beds
     * @param $bathrooms
     * @param $crew
     * @param $boats_types_id
     * @param $boats_models_id
     * @param $sail_types_id
     * @return array
     */
    protected function inputConversion(
        $user_id,
        $name,
        $length,
        $beam,
        $depth,
        $passenger,
        $cabins,
        $guests_beds,
        $bathrooms,
        $crew,
        $boats_types_id,
        $boats_models_id,
        $sail_types_id,
    ): array
    {
        $data = [];
        if (!is_null($user_id)) $data['user_id'] = (int)$user_id;
        if (!is_null($name)) $data['name'] = (string)$name;
        if (!is_null($length)) $data['length'] = (float)$length;
        if (!is_null($beam)) $data['beam'] = (float)$beam;
        if (!is_null($depth)) $data['depth'] = (float)$depth;
        if (!is_null($passenger)) $data['passenger'] = (int)$passenger;
        if (!is_null($cabins)) $data['cabins'] = (int)$cabins;
        if (!is_null($guests_beds)) $data['guests_beds'] = (int)$guests_beds;
        if (!is_null($bathrooms)) $data['bathrooms'] = (int)$bathrooms;
        if (!is_null($crew)) $data['crew'] = (int)$crew;
        if (!is_null($boats_types_id)) $data['boats_types_id'] = (int)$boats_types_id;
        if (!is_null($boats_models_id)) $data['boats_models_id'] = (int)$boats_models_id;
        if (!is_null($sail_types_id)) $data['sail_types_id'] = (int)$sail_types_id;

        return $data;
    }
}
