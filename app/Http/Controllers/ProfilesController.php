<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Show the profile of the current user.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->getActivity($user)
        ]);
    }

    /**
     * Get the activity associated with the current user.
     *
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    protected function getActivity(User $user)
    {
        return $user->activities()->latest()
            ->with('subject')->get()->take(50)->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
