<?php

namespace App\Models;

use App\Casts\HtmlSpecialCharsCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mews\Purifier\Casts\CleanHtml;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    protected $casts = [
        'name' => HtmlSpecialCharsCast::class,
        'description' => CleanHtml::class,
    ];


    /**
     * User has many tags
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Tags belong to many galleries
     *
     * @return BelongsToMany
     */
    public function galleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class);
    }


    /**
     * Galleries belong to a specific tag
     *
     * @return BelongsToMany
     */
    public function filteredGalleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class)
            ->wherePivot('tag_id', $this->id)
            ->orderBy('updated_at', 'DESC');
    }
}
