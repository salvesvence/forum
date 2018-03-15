<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the reply.
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function delete(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }
}
