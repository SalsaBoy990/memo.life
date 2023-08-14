<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    /**
     * @param  string  $handle
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(string $handle): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // get user by the unique handle
        $realHandle = str_replace('@', '', $handle);
        $user = User::with('user_detail')->where('handle', '=', $realHandle)->firstOrFail();

        // only public
        $galleries = Gallery::where('user_id', '=', $user->id)
            ->where('status', '=', 'public')
            ->orderByDesc('start')
            ->paginate(5);

        return view('pages.public.gallery.index')->with([
            'user' => $user,
            'galleries' => $galleries
        ]);
    }


    /**
     * @param  string  $handle
     * @param  string  $slug
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(
        string $handle,
        string $slug
    ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {

        $user = User::where('handle', '=', str_replace('@', '', $handle))->firstOrFail();

        $gallery = Gallery::with(['photos', 'tags'])
            ->where('slug', '=', $slug)
            ->where('user_id', '=', $user->id)
            ->firstOrFail();

        return view('pages.public.gallery.show')->with([
            'user' => $user,
            'gallery' => $gallery
        ]);
    }


    /**
     * @param  string  $handle
     * @param  string  $slug
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function tag(
        string $handle,
        string $slug
    ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {

        $user = User::where('handle', '=', str_replace('@', '', $handle))->firstOrFail();

        $tag = Tag::where('slug', '=', $slug)
            ->where('user_id', '=', $user->id)
            ->firstOrFail();

        $galleries = $tag->filteredGalleries()->where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(3);


        return view('pages.public.gallery.tag')->with([
            'tag' => $tag,
            'user' => $user,
            'galleries' => $galleries
        ]);
    }
}
