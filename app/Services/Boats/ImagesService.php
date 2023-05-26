<?php

declare( strict_types=1 );

namespace App\Services\Boats;

use App\Repository\Boats\ImagesRepository;
use App\Exceptions\DataCreateFail;
use App\Exceptions\DataUpdateFail;
use App\Exceptions\DataGetFail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\File;

class ImagesService
{
    protected string $dir_mini = 'mini';
    protected string $dir_big = 'big';
    protected int $min_width = 440;

    /**
     * @param ImagesRepository $imagesRepository
     */
    public function __construct(protected ImagesRepository $imagesRepository)
    {
    }

    /**
     * @param $file
     * @param string $boats_id
     * @param string $name
     * @param string $type
     * @param int $lastModifiedDate
     * @param int $width
     * @param int $height
     * @return string
     * @throws DataCreateFail
     */
    public function create(
        $file,
        string $boats_id,
        string $name,
        string $type,
        int $lastModifiedDate,
        int $width,
        int $height
    ): array
    {
        $path = $file->store('/', 'boats_images');
        $path_mini = $this->dir_mini . '/' . $path;
        $min_heght = $height * $this->min_width / $width;
        if (
            strlen($path) === 0 ||
            (!Storage::disk('boats_images')->put('/' . $path_mini, (new ImageManager)->make($file)->resize($this->min_width, $min_heght)->stream()))
        ) throw new DataCreateFail('Store error');
        try {
            $result =
                $this->imagesRepository->create(
                    boats_id: $boats_id,
                    path: $path,
                    path_mini: $path_mini,
                    name: $name,
                    type: $type,
                    lastModifiedDate: $lastModifiedDate,
                    width: $width,
                    height: $height
                );
            return ['id' => $result];
        } catch (QueryException $e) {
            throw new DataCreateFail($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param array $data
     * @param string $boats_images_id
     * @return mixed
     * @throws DataUpdateFail
     */
    public function update(array $data, string $boats_images_id)
    {
        $update_data = [];
        foreach ($data as $key => $item) {
            if ($key === 'rotate_count') continue;
            $update_data[str_replace(':', 'x', $key)] = $item;
        }
        if (array_key_exists('rotate_count', $data)) {
            try {
                $image = $this->imagesRepository->getImage($boats_images_id);
            } catch (\Exception $e) {
                throw new DataUpdateFail('Error getting information about the image');
            }

            $update_data['width'] = $data['rotate_count'] % 2 ? $image->height : $image->width;
            $update_data['height'] = $data['rotate_count'] % 2 ? $image->width : $image->height;
            $update_data['path_big'] = $this->dir_big . '/' . $image->path_origin;
            $update_data['path_min'] = $this->dir_mini . '/' . $image->path_origin;

            // Вращаем картинку
            // Картинка большая
            try {
                $file = Storage::disk('boats_images')->get($image->path_big);
            } catch (\Exception $e) {
                throw new DataUpdateFail('Store error');
            }
            if (!Storage::disk('boats_images')->put('/' . $update_data['path_big'], (new ImageManager)->make($file)->rotate(90 * (4 - $data['rotate_count']))->stream()))
                throw new DataUpdateFail('Store error');
            // Картинка маленькая
            try {
                $file = Storage::disk('boats_images')->get($update_data['path_big']);
            } catch (\Exception $e) {
                throw new DataUpdateFail('Store error');
            }
            $min_heght = $update_data['height'] * $this->min_width / $update_data['width'];
            if (!Storage::disk('boats_images')->put('/' . $update_data['path_min'], (new ImageManager)->make($file)->resize($this->min_width, $min_heght)->stream()))
                throw new DataUpdateFail('Store error');
        }
        if (array_key_exists('is_main', $data)) {

            // Mock!!!!!!!!!!!!!!!!
        }
        return $this->imagesRepository->update($boats_images_id, $update_data);
    }

    /**
     * @param string $boats_images_id
     * @return ImagesService
     * @throws DataUpdateFail
     */
    public function getImage(string $boats_images_id)
    {
        try {
            $image = $this->imagesRepository->getImage($boats_images_id)->toArray();
        } catch (\Exception $e) {
            throw new DataUpdateFail('Error getting information about the image');
        }
        return $this->transformImage($image);
    }

    /**
     * @param string $boats_images_id
     * @return array
     * @throws DataUpdateFail
     */
    public function getImagesList(string $boats_id)
    {
        try {
            $images_list = $this->imagesRepository->getImagesList($boats_id)->toArray();
        } catch (\Exception $e) {
            throw new DataUpdateFail('Error getting information about the image');
        }
        $result = [];
        foreach ($images_list as $image) {
            $result[]=$this->transformImage($image);
        }
        return $result;
    }
    /**
     * @param array $image
     * @return array
     */
    protected function transformImage( array $image){
        $result = [
            'id' => $image['id'],
            'path_big' => $image['path_big'],
            'path_min' => $image['path_min'],
            'width' => (int)$image['width'],
            'height' => (int)$image['height'],
        ];
        if (!is_null($image['16x9_left'])) $result['16:9']['left'] = (float)$image['16x9_left'];
        if (!is_null($image['16x9_top'])) $result['16:9']['top'] = (float)$image['16x9_top'];
        if (!is_null($image['16x9_scale'])) $result['16:9']['scale'] = (float)$image['16x9_scale'];
        if (!is_null($image['4x3_left'])) $result['4:3']['left'] = (float)$image['4x3_left'];
        if (!is_null($image['4x3_top'])) $result['4:3']['top'] = (float)$image['4x3_top'];
        if (!is_null($image['4x3_scale'])) $result['4:3']['scale'] = (float)$image['4x3_scale'];
        if (!is_null($image['1x1_left'])) $result['1:1']['left'] = (float)$image['1x1_left'];
        if (!is_null($image['1x1_top'])) $result['1:1']['top'] = (float)$image['1x1_top'];
        if (!is_null($image['1x1_scale'])) $result['1:1']['scale'] = (float)$image['1x1_scale'];
        if (!is_null($image['3x4_left'])) $result['3:4']['left'] = (float)$image['3x4_left'];
        if (!is_null($image['3x4_top'])) $result['3:4']['top'] = (float)$image['3x4_top'];
        if (!is_null($image['3x4_scale'])) $result['3:4']['scale'] = (float)$image['3x4_scale'];
        if (!is_null($image['9x16_left'])) $result['9:16']['left'] = (float)$image['9x16_left'];
        if (!is_null($image['9x16_top'])) $result['9:16']['top'] = (float)$image['9x16_top'];
        if (!is_null($image['9x16_scale'])) $result['9:16']['scale'] = (float)$image['9x16_scale'];

        return $result;
    }

}

