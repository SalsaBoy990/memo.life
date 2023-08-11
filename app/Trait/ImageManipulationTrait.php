<?php

namespace App\Trait;

use Intervention\Image\Exception\NotWritableException;
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
     * @return bool
     */
    public function createPhotoFoldersIfNotExist(string $userFolder, string $photosFolder, string $galleryFolder): bool
    {
        $success = true;
        if (!is_dir(storage_path($userFolder))) {
            $success = mkdir(storage_path($userFolder), 0775, true);
        }

        if (!is_dir(storage_path($photosFolder))) {
            $success = mkdir(storage_path($photosFolder), 0775, true);
        }

        if (!is_dir(storage_path($galleryFolder))) {
            $success = mkdir(storage_path($galleryFolder), 0775, true);
        }

        return $success;
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
        $imageStoragePath = 'storage/app/user/'.$userId.'/photos/'.$galleryId.'/'.$image;
        return file_exists($imageStoragePath); // Storage::exists(...
    }


    /**
     * Deletes Photo
     *
     * @param  int  $userId
     * @param  int  $galleryId
     * @param  string  $image
     * @return bool
     */
    public function deletePhoto(int $userId, int $galleryId, string $image): bool
    {
        $imageStoragePath = 'storage/app/user/'.$userId.'/photos/'.$galleryId.'/'.$image;
        if (file_exists($imageStoragePath)) { // Storage::exists(...
            return unlink($imageStoragePath); // Storage::delete(...
        }
        return true;
    }


    /**
     * Saves Photo, Cover Image, but processed with Intervention Image (resize & compress)
     *
     * @param  string  $inputImage
     * @param  string  $imagePath
     * @param  string  $thumbnailImagePath
     * @param  int  $imageQuality
     * @param  int  $thumbnailQuality
     * @return bool
     */
    public function saveImage(
        string $inputImage,
        string $imagePath,
        string $thumbnailImagePath,
        int $imageQuality = 90,
        int $thumbnailQuality = 75
    ): bool {


        try {
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

                return true;

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

                return true;

            }
        } catch (NotWritableException|\Exception $ex) {
            return false;
        }
    }


    /**
     * @param  object  $image
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
            'imageFileName' => $imageFileName,
            'thumbnailImagePath' => $thumbnailImagePath,
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
     * @return bool
     */
    public function createCoverImageFoldersIfNotExist(
        string $userFolder,
        string $coverImagesFolder,
        string $coverImagesYearMonthFolder
    ): bool {
        $success = true;
        if (!is_dir(storage_path($userFolder))) {
            $success = mkdir(storage_path($userFolder), 0775, true);
        }
        if (!is_dir(storage_path($coverImagesFolder))) {
            $success = mkdir(storage_path($coverImagesFolder), 0775, true);
        }
        if (!is_dir(storage_path($coverImagesYearMonthFolder))) {
            $success = mkdir(storage_path($coverImagesYearMonthFolder), 0775, true);
        }

        return $success;
    }


    /**
     * Cover image exists?
     *
     * @param  int  $userId
     * @param  string  $yearMonthFolder
     * @param  string  $coverImage
     * @return bool
     */
    private function isCoverImageExists(int $userId, string $yearMonthFolder, string $coverImage): bool
    {
        $imageStoragePath = 'storage/app/user/'.$userId.'/cover_images/'.$yearMonthFolder.'/'.$coverImage;
        return file_exists($imageStoragePath); // Storage::exists(...
    }


    /**
     * Deletes the cover image
     *
     * @param  int  $userId
     * @param  string  $yearMonthFolder
     * @param  string  $coverImage
     * @return bool
     */
    public function deleteCoverImage(int $userId, string $yearMonthFolder, string $coverImage): bool
    {
        $imageStoragePath = 'storage/app/user/'.$userId.'/cover_images/'.$yearMonthFolder.'/'.$coverImage;
        if (file_exists($imageStoragePath)) { // Storage::exists(...
            return unlink($imageStoragePath); // Storage::delete(...
        }
        return true;
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
        object $coverImage,
        int $userId,
        string $coverImagesYearMonthFolder
    ): array {
        if (!$isValid) {
            $imageFileName = 'placeholder.jpg';
            $thumbnailImageFileName = 'placeholder.jpg';
        } else {
            // with jpg extension (it will be converted to jpg in case of other extensions)
            $imageFileName = $userId.'_'.time().'_'.pathinfo($coverImage->getClientOriginalName(),
                    PATHINFO_FILENAME).'.jpg';

            $thumbnailImageFileName = $userId.'_'.time().'_'.pathinfo($coverImage->getClientOriginalName(),
                    PATHINFO_FILENAME).'_thumbnail.jpg';
        }

        $imagePath = storage_path($coverImagesYearMonthFolder).'/'.$imageFileName;
        $thumbnailImagePath = storage_path($coverImagesYearMonthFolder).'/'.$thumbnailImageFileName;

        return [
            'imagePath' => $imagePath,
            'imageFileName' => $imageFileName,
            'thumbnailImagePath' => $thumbnailImagePath,
            'thumbnailImageFileName' => $thumbnailImageFileName,
        ];
    }


}
