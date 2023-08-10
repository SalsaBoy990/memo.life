<?php

namespace App\Models;

use App\Casts\HtmlSpecialCharsCast;
use App\Interface\TagInterface;
use App\Trait\QueryTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mews\Purifier\Casts\CleanHtml;

class Tag extends Model implements TagInterface
{
    use HasFactory;
    use QueryTrait;

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
    public function fiteredGalleries(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class)
            ->wherePivot('tag_id', $this->id)
            ->orderBy('updated_at', 'DESC');
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


    /**
     * Get tags with the galleries belonging to them (for user)
     *
     * @param  Tag  $tag
     * @return LengthAwarePaginator
     */
    public static function getTagWithItsGalleries(Tag $tag): LengthAwarePaginator
    {
        return $tag->fiteredGalleries()
            ->where('user_id', Auth()->id())
            ->orderBy('created_at', 'DESC')
            ->paginate(self::TAGS_PER_PAGE);
    }


    /**
     * Get the galleries belonging to the tags (for user)
     *
     * @return Collection
     */
    public static function getGalleriesFilteredByTag(): Collection
    {
        $callback = function ($query) {
            $this->queryByUserId($query);
        };

        return Tag::whereRelation('galleries', 'user_id', Auth()->id())->with(['galleries' => $callback])->get();
    }
}
