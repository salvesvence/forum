<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable
{
    /**
     * Get all favorite models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Store a new favorite model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if(! $this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    /**
     * @return bool
     */
    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * @return bool
     */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        return $this->favorites()->where($attributes)->delete();
    }

    /**
     * @return mixed
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}