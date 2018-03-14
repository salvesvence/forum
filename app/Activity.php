<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the subject associated with the current activity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user)
    {
        return $user->activities()->latest()
            ->with('subject')->get()->take(50)->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
