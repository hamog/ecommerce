<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Brand extends Model
{
    use HasFactory, HasSlug, Searchable;

    protected $guarded = [];

    /**
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * Scope a query to only include listings that are returned by scout
     *
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeWhereScout(Builder $query, string $search): Builder
    {
        return $query->whereIn(
            'id',
            self::search($search)
                ->get()
                ->pluck('id'),
        );
    }
}
