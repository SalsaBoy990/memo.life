<?php

namespace App\Http\Controllers;

use App\Interface\FileInterface;
use App\Trait\FileAccessTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileAccessController extends Controller implements FileInterface
{
    use FileAccessTrait;


    /**
     * Delivers the cover image (of a gallery) if user can have access to it
     * @param  Request  $request
     * @return BinaryFileResponse
     */
    public function serveCoverImage(Request $request): BinaryFileResponse
    {
        return $this->serveImage($request, self::IMAGE_TYPES['cover']);
    }


    /**
     * Delivers the photo if user can have access to it
     *
     * @param  Request  $request
     * @return BinaryFileResponse
     */
    public function servePhoto(Request $request): BinaryFileResponse
    {
        return $this->serveImage($request, self::IMAGE_TYPES['photo']);
    }


    /**
     * Delivers the avatar image if user can have access to it
     * Currently, this is not used though...
     *
     * @param  Request  $request
     * @return BinaryFileResponse
     */
    public function serveUserAvatar(Request $request): BinaryFileResponse
    {
        return $this->serveImage($request, self::IMAGE_TYPES['avatar']);
    }
}
