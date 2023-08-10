<?php

namespace App\Trait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

trait FileAccessTrait {

    /**
     * @param  Request  $request
     * @param  string  $type
     * @return BinaryFileResponse
     */
    public function serveImage(Request $request, string $type): BinaryFileResponse
    {
        if (Auth::user() && Auth::id() === intval($request->user) || Auth::user()->hasRoles('super-admininstrator')) {
            // Here we don't use the Storage facade that assumes the storage/app folder
            // So filename should be a relative path inside storage to your file like 'app/userfiles/report1253.pdf'
            $filePath = '';

            switch ($type) {
                case 'avatar':
                    $filePath = storage_path('app/user/' . $request->user . '/' . $request->file);
                    break;

                case 'photo':
                    $path = explode('/', $request->getPathInfo());
                    $galleryFolder = $path[4];
                    $filePath = storage_path('app/user/' . Auth::id() . '/photos/' . $galleryFolder . '/' . $request->file);
                    break;

                case 'cover':
                    $path = explode('/', $request->getPathInfo());
                    $yearMonthFolder = $path[4];
                    $filePath = storage_path('app/user/' . Auth::id() . '/cover_images/' . $yearMonthFolder . '/' . $request->file);
                    break;

                default:
                    break;
            }

            return response()->file($filePath);
        } else {
            return abort('404');
        }
    }
}
