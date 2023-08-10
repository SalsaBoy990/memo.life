<?php

namespace App\Trait;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Image manipulation functions with Intervention Image,
 * and other utils functions (like generating folders, saving images)
 */
trait ImageManipulationTrait
{
    // PHOTOS START

    /**
     * Create folders for the photos
     *
     * @param  string  $userFolder
     * @param  string  $photosFolder
     * @param  string  $galleryFolder
     *
     * @return void
     */
    public function createPhotoFoldersIfNotExist(string $userFolder, string $photosFolder, string $galleryFolder): void
    {
        if (!is_dir(storage_path($userFolder))) {
            mkdir(storage_path($userFolder), 0775, true);
        }

        if (!is_dir(storage_path($photosFolder))) {
            mkdir(storage_path($photosFolder), 0775, true);
        }

        if (!is_dir(storage_path($galleryFolder))) {
            mkdir(storage_path($galleryFolder), 0775, true);
        }
    }


    /**
     * Photo exists?
     *
     * @param  int  $userId
     * @param  int  $galleryId
     * @param  string  $image
     * @return bool
     */
    public function isPhotoExists(int $userId, int $galleryId, string $image): bool
    {
        $imageStoragePath = '/user/'.$userId.'/photos/'.$galleryId.'/'.$image;
        return Storage::exists($imageStoragePath);
    }


    /**
     * Deletes Photo
     *
     * @param  int  $userId
     * @param  int  $galleryId
     * @param  string  $image
     * @return void
     */
    public function deletePhoto(int $userId, int $galleryId, string $image): void
    {
        $imageStoragePath = '/user/'.$userId.'/photos/'.$galleryId.'/'.$image;
        if (Storage::exists($imageStoragePath)) {
            Storage::delete($imageStoragePath);
        }
    }


    /**
     * Saves Photo, but processed with Intervention Image (resize & compress)
     *
     * @param  string  $inputImage
     * @param  string  $imagePath
     * @param  string  $thumbnailImagePath
     * @param  int  $imageQuality
     * @param  int  $thumbnailQuality
     * @return void
     */
    public function savePhoto(
        string $inputImage,
        string $imagePath,
        string $thumbnailImagePath,
        int $imageQuality = 90,
        int $thumbnailQuality = 75
    ): void {

        $image = Image::make($inputImage);
        $imageWidth = $image->width();
        $imageHeight = $image->height();

        if ($imageWidth > $imageHeight || $imageHeight > $imageWidth) {
            // Landscape & portrait will have a width with a maximum of 2500pxs
            ($imageWidth > 2500) ?
                $image->resize(2500, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                    ->save($imagePath, $imageQuality, 'jpg')
                    ->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($thumbnailImagePath, $thumbnailQuality, 'jpg')
                :
                $image->save($imagePath, $imageQuality, 'jpg')
                    ->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($thumbnailImagePath, $thumbnailQuality, 'jpg');
        } else {
            // Square
            ($imageWidth > 2500) ?
                $image->resize(2500, 2500, function ($constraint) {
                    $constraint->aspectRatio();
                })
                    ->save($imagePath, $imageQuality, 'jpg')
                    ->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($thumbnailImagePath, $thumbnailQuality, 'jpg')
                :
                $image->save($imagePath, $imageQuality, 'jpg')
                    ->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($thumbnailImagePath, $thumbnailQuality, 'jpg');
        }
    }


    /**
     * @param  mixed  $image
     * @param  int  $userId
     * @param  string  $galleryFolder
     *
     * @return array
     */
    public function generatePhotoPaths($image, int $userId, string $galleryFolder): array
    {
        // with jpg extension (it will be converted to jpg in case of other extensions)
        $imageFileName = $userId.'_'.time().'_'.pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME).'.jpg';
        $thumbnailImageFileName = $userId.'_'.time().'_'.pathinfo($image->getClientOriginalName(),
                PATHINFO_FILENAME).'_thumbnail.jpg';

        $imagePath = storage_path($galleryFolder).'/'.$imageFileName;
        $thumbnailImagePath = storage_path($galleryFolder).'/'.$thumbnailImageFileName;

        return [
            'imagePath' => $imagePath,
            'thumbnailImagePath' => $thumbnailImagePath,
            'imageFileName' => $imageFileName,
            'thumbnailImageFileName' => $thumbnailImageFileName,
        ];
    }
    // PHOTOS END


    // COVER IMAGES START

    /**
     * Create folders for the cover images
     *
     * @param  string  $userFolder
     * @param  string  $coverImagesFolder
     * @param  string  $coverImagesYearMonthFolder
     *
     * @return void
     */
    public function createCoverImageFoldersIfNotExist(
        string $userFolder,
        string $coverImagesFolder,
        string $coverImagesYearMonthFolder
    ): void {
        if (!is_dir(storage_path($userFolder))) {
            mkdir(storage_path($userFolder), 0775, true);
        }
        if (!is_dir(storage_path($coverImagesFolder))) {
            mkdir(storage_path($coverImagesFolder), 0775, true);
        }
        if (!is_dir(storage_path($coverImagesYearMonthFolder))) {
            mkdir(storage_path($coverImagesYearMonthFolder), 0775, true);
        }
    }


    /**
     * Cover image exists?
     *
     * @param  int  $userId
     * @param  string  $coverImage
     * @return bool
     */
    public function isCoverImageExists(int $userId, string $coverImage): bool
    {
        $imageStoragePath = '/user/'.$userId.'/cover_images/'.$coverImage;
        return Storage::exists($imageStoragePath);
    }


    /**
     * Deletes the cover image
     *
     * @param  int  $userId
     * @param  string  $coverImage
     * @return void
     */
    public function deleteCoverImage(int $userId, string $coverImage): void
    {
        $imageStoragePath = '/user/'.$userId.'/cover_images/'.$coverImage;
        if (Storage::exists($imageStoragePath)) {
            Storage::delete($imageStoragePath);
        }
    }


    /**
     * @param  bool  $isValid
     * @param  mixed  $coverImage
     * @param  int  $userId
     * @param  string  $coverImagesYearMonthFolder
     *
     * @return array
     */
    public function generateCoverImagePaths(
        bool $isValid,
        $coverImage,
        int $userId,
        string $coverImagesYearMonthFolder
    ): array {
        if (!$isValid) {
            $imageFileName = 'placeholder.jpg';
            $thumbnailImageFileName = 'placeholder.jpg';
        } else {
            // with jpg extension (it will be converted to jpg in case of other extensions)
            $imageFileName = pathinfo($coverImage->getClientOriginalName(),
                    PATHINFO_FILENAME).'_'.$userId.'_'.time().'.jpg';

            $thumbnailImageFileName = pathinfo($coverImage->getClientOriginalName(),
                    PATHINFO_FILENAME).'_'.$userId.'_'.time().'_thumbnail.jpg';
        }

        $imagePath = storage_path($coverImagesYearMonthFolder).'/'.$imageFileName;
        $thumbnailImagePath = storage_path($coverImagesYearMonthFolder).'/'.$thumbnailImageFileName;
        //$imageFileName->move(storage_path('app/user/' . $request->user->id . '/coverimages/' . $currentDate), $coverImageName);

        return [
            'imagePath' => $imagePath,
            'thumbnailImagePath' => $thumbnailImagePath,
            'imageFileName' => $imageFileName,
            'thumbnailImageFileName' => $thumbnailImageFileName,
        ];
    }


}
