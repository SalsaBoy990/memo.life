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

}
