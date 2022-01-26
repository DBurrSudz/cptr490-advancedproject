<?php

namespace App\Policies;
use App\Policies\Contracts\UserInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    /**
     * Decides whether the authenticated user has permission to perform actions on Announcements.
     * @param $user The authenticated user.
     */
    public function manageAnnouncements(UserInterface $user)
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny("Must be an Admin to perform this action.");
    }
}
