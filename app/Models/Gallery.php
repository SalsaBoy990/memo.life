<?php

namespace App\Models;

use App\Casts\HtmlSpecialCharsCast;
use App\Interface\GalleryInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mews\Purifier\Casts\CleanHtml;

class Gallery extends Model implements GalleryInterface
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'title',
        'slug',
        'story',
        'cover_image',
        'thumbnail_image',
        'start',
        'end',
        'location',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'name' => HtmlSpecialCharsCast::class,
        'story' => CleanHtml::class,
    ];


    /**
     * Gallery has many photos
     *
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Galleries belong to many tags
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'galleries_tags');
    }

    /**
     * User has many galleries
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
