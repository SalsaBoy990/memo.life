<?php

namespace App\Models;

use App\Casts\HtmlSpecialCharsCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Casts\CleanHtml;

class Photo extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description',
        'full_image',
        'thumbnail_image',
        'gallery_id',
        'user_id'
    ];

    protected $casts = [
        'title'          => HtmlSpecialCharsCast::class,
        'description'    => CleanHtml::class,
    ];


    /**
     * @return BelongsTo
     */
    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }


    /**
     * @param  string  $userFolder
     * @param  string  $photosFolder
     * @param  string  $galleryFolder
     *
     * @return void
     */
    public static function createFoldersIfNotExist(
        string $userFolder,
        string $photosFolder,
        string $galleryFolder
    ): void {
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
     * @param  int  $userId
     * @param  int  $galleryId
     * @param  string  $image
     *
     * @return bool
     */
    public static function checkIfImageExists(int $userId, int $galleryId, string $image): bool
    {
        $imageStoragePath = '/user/'.$userId.'/photos/'.$galleryId.'/'.$image;
        return Storage::exists($imageStoragePath);
    }


    /**
     * @param  int  $userId
     * @param  int  $galleryId
     * @param  string  $image
     *
     * @return void
     */
    public static function deleteImage(int $userId, int $galleryId, string $image): void
    {
        $imageStoragePath = '/user/'.$userId.'/photos/'.$galleryId.'/'.$image;
        if (Storage::exists($imageStoragePath)) {
            Storage::delete($imageStoragePath);
        }
    }

    /**
     * @param  mixed  $image
     * @param  int  $userId
     * @param  string  $galleryFolder
     *
     * @return array
     */
    public static function generateImagePaths(object $image, int $userId, string $galleryFolder): array
    {
        // with jpg extension (it will be converted to jpg in case of other extensions)
        $imageFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME).$userId.'_'.time().'_'.'.jpg';
        $thumbnailImageFileName = pathinfo($image->getClientOriginalName(),
                PATHINFO_FILENAME).$userId.'_'.time().'_thumbnail.jpg';

        $imagePath = storage_path($galleryFolder).'/'.$imageFileName;
        $thumbnailImagePath = storage_path($galleryFolder).'/'.$thumbnailImageFileName;

        return [
            'imagePath' => $imagePath,
            'thumbnailImagePath' => $thumbnailImagePath,
            'imageFileName' => $imageFileName,
            'thumbnailImageFileName' => $thumbnailImageFileName,
        ];
    }
}
