<?php

namespace Tests\Unit\App\Trait;

use App\Interface\ImageInterface;
use App\Trait\ImageManipulationTrait;
use PHPUnit\Framework\TestCase;


class ImageManipulationTest extends TestCase implements ImageInterface
{
    use ImageManipulationTrait;

    private string $photo;
    private string $coverImagePath;

    private string $testImage;
    private string $testImageWithExtension;

    private string $yearMonthFolder;
    private int $userId;
    private int $galleryId;


    protected function setUp(): void
    {
        parent::setUp();
        $this->userId = 999;
        $this->galleryId = 22;
        $this->yearMonthFolder = '202308';

        $this->photo = '1_1658705558_szeged7.jpg';
        $this->coverImage = '1_1658685363_montenegro.jpg';

        $this->testImage = 'img_snowtops';
        $this->testImageWithExtension = 'img_snowtops.jpg';


    }

    // PHOTOS START

    /**
     * @return void
     */
    public function test_photo_exists(): void
    {
        $exists = $this->isPhotoExists(1, 1, $this->photo);
        $this->assertTrue($exists);
    }


    /**
     * @return void
     */
    public function test_create_photo_folders_if_not_exist(): void
    {
        $userFolder = 'app/user/'.$this->userId;
        $photosFolder = $userFolder.'/photos';
        $galleryFolder = $photosFolder.'/'.$this->galleryId;

        $success = $this->createPhotoFoldersIfNotExist($userFolder, $photosFolder, $galleryFolder);
        $this->assertTrue($success);
    }


    /**
     * Unfortunately, cannot test processing and saving image with Intervention (cannot use Image facade)
     * Intervention Image package is probably tested by the developers.
     *
     * @return void
     */
    public function test_save_photo(): void
    {
        $inputImage = 'public/images/'.$this->testImageWithExtension;
        $savePath = 'storage/app/user/'.$this->userId.'/photos/'.$this->galleryId.'/'.$this->testImageWithExtension;
        $success = copy($inputImage, $savePath);
        $this->assertTrue($success);
    }


    /**
     * @return void
     */
    public function test_delete_photo(): void
    {
        $deleted = $this->deletePhoto($this->userId, $this->galleryId, $this->testImageWithExtension);
        $this->assertTrue($deleted);
    }


    /**
     * @return void
     */
    public function test_generate_photo_paths(): void
    {
        $userFolder = 'app/user/'.$this->userId;
        $photosFolder = $userFolder.'/photos';
        $galleryFolder = $photosFolder.'/'.$this->galleryId;

        $array = $this->generatePhotoPaths($this->testImage, $this->userId, $galleryFolder);

        $imagePath = $array['imagePath'];
        $thumbnailImagePath = $array['thumbnailImagePath'];
        $imageFileName = $array['imageFileName'];
        $thumbnailImageFileName = $array['thumbnailImageFileName'];

        $this->assertTrue(str_contains($imagePath, $this->testImageWithExtension));
        $this->assertTrue(str_contains($imagePath, $galleryFolder));

        $this->assertTrue(str_contains($thumbnailImagePath, $this->testImage.'_thumbnail.jpg'));
        $this->assertTrue(str_contains($thumbnailImagePath, $galleryFolder));

        $this->assertTrue(str_contains($imageFileName, $this->testImageWithExtension));
        $this->assertTrue(str_contains($imageFileName, $this->userId.'_'));

        $this->assertTrue(str_contains($thumbnailImageFileName, $this->testImage.'_thumbnail.jpg'));
        $this->assertTrue(str_contains($imageFileName, $this->userId.'_'));
    }


    /**
     * Overwrite
     *
     * @param  mixed  $image
     * @param  int  $userId
     * @param  string  $galleryFolder
     *
     * @return array
     */
    private function generatePhotoPaths($image, int $userId, string $galleryFolder): array
    {
        // with jpg extension (it will be converted to jpg in case of other extensions)
        $imageFileName = $userId.'_'.time().'_'.$image.'.jpg';
        $thumbnailImageFileName = $userId.'_'.time().'_'.$image.'_thumbnail.jpg';

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
     * @return void
     */
    public function test_cover_image_exists(): void
    {
        $exists = $this->isCoverImageExists(1, $this->yearMonthFolder, $this->coverImage);
        $this->assertTrue($exists);
    }


    /**
     * @return void
     */
    public function test_create_cover_image_folders_if_not_exist(): void
    {
//        $currentDate = date("Ym");
        $userFolder = 'app/user/'.$this->userId;
        $coverImagesFolder = $userFolder.'/cover_images';
        $coverImagesYearMonthFolder = $coverImagesFolder.'/'.$this->yearMonthFolder;

        $success = $this->createCoverImageFoldersIfNotExist($userFolder, $coverImagesFolder,
            $coverImagesYearMonthFolder);
        $this->assertTrue($success);
    }


    /**
     * Unfortunately, cannot test processing and saving image with Intervention (cannot use Image facade)
     * Intervention Image package is probably tested by the developers.
     *
     * @return void
     */
    public function test_save_cover_image(): void
    {
        $inputImage = 'public/images/'.$this->testImageWithExtension;
        $savePath = 'storage/app/user/'.$this->userId.'/cover_images/'.$this->yearMonthFolder.'/'.$this->testImageWithExtension;
        $success = copy($inputImage, $savePath);
        $this->assertTrue($success);
    }


    /**
     * @return void
     */
    public function test_delete_cover_image(): void
    {
        $deleted = $this->deleteCoverImage($this->userId, $this->yearMonthFolder, $this->testImageWithExtension);
        $this->assertTrue($deleted);
    }


    /**
     * @return void
     */
    public function test_generate_cover_image_paths(): void
    {
        $userFolder = 'app/user/'.$this->userId;
        $coverImagesFolder = $userFolder.'/cover_images';
        $coverImagesYearMonthFolder = $coverImagesFolder.'/'.$this->yearMonthFolder;

        $array = $this->generateCoverImagePaths(true, $this->testImage, $this->userId, $coverImagesYearMonthFolder);

        $imagePath = $array['imagePath'];
        $thumbnailImagePath = $array['thumbnailImagePath'];
        $imageFileName = $array['imageFileName'];
        $thumbnailImageFileName = $array['thumbnailImageFileName'];

        $this->assertTrue(str_contains($imagePath, $this->testImageWithExtension));
        $this->assertTrue(str_contains($imagePath, $coverImagesYearMonthFolder));

        $this->assertTrue(str_contains($thumbnailImagePath, $this->testImage.'_thumbnail.jpg'));
        $this->assertTrue(str_contains($thumbnailImagePath, $coverImagesYearMonthFolder));

        $this->assertTrue(str_contains($imageFileName, $this->testImageWithExtension));
        $this->assertTrue(str_contains($imageFileName, $this->userId.'_'));

        $this->assertTrue(str_contains($thumbnailImageFileName, $this->testImage.'_thumbnail.jpg'));
        $this->assertTrue(str_contains($imageFileName, $this->userId.'_'));
    }


    /**
     * Overwrite (to be able to test it)
     *
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
            $imageFileName = $userId.'_'.time().'_'.$coverImage.'.jpg';

            $thumbnailImageFileName = $userId.'_'.time().'_'.$coverImage.'_thumbnail.jpg';
        }

        $imagePath = storage_path($coverImagesYearMonthFolder).'/'.$imageFileName;
        $thumbnailImagePath = storage_path($coverImagesYearMonthFolder).'/'.$thumbnailImageFileName;

        return [
            'imagePath' => $imagePath,
            'thumbnailImagePath' => $thumbnailImagePath,
            'imageFileName' => $imageFileName,
            'thumbnailImageFileName' => $thumbnailImageFileName,
        ];
    }


}
