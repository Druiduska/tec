<?php

declare( strict_types=1 );

namespace App\Repository\Boats;

use App\Models\BoatsImages;

class ImagesRepository
{

    public function create(
        string $boats_id,
        string $path,
        string $path_mini,
        string $name,
        string $type,
        int    $lastModifiedDate,
        int    $width,
        int    $height,
    ): string
    {

        $boatImages = BoatsImages::create([
            'boats_id' => $boats_id,
            'path_origin' => $path,
            'path_big' => $path,
            'path_min' => $path_mini,
            'name' => $name,
            'type' => $type,
            'lastModifiedDate' => $lastModifiedDate,
            'width' => $width,
            'height' => $height,
        ]);
        return (string)$boatImages->id;
    }
    public function getImage(string $id){
        return BoatsImages::where('id', $id)->first();
    }
    public function update(string $id, $data){
        return BoatsImages::where('id', $id)->update($data);
    }
    public function getImagesList(string $boats_id){
        return BoatsImages::where('boats_id', $boats_id)->get();
    }
}
