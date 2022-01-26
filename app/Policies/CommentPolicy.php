<?php

namespace App\Policies;

use App\Models\Comment;
use App\Policies\Contracts\UserInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the authenticated user has permissions to create a new Comment.
     */
    public function create(UserInterface $user)
    {
        return !$user->isAdmin()
            ? Response::allow()
            : Response::deny("Only Students are allowed to create comments.");
    }

    /**
     * Checks if the authenticated user has permissions to edit and update a comment.
     */
    public function editAndUpdate(UserInterface $user, Comment $comment)
    {
        return !$user->isAdmin() && $comment->user->is($user)
            ? Response::allow()
            : Response::deny(
                "You are not allowed to edit or update this comment.",
            );
    }

    /**
     * Checks if the authenticated user has permissions to delete a job.
     */
    public function destroy(UserInterface $user, Comment $comment)
    {
        return (!$user->isAdmin() && $comment->user->is($user)) ||
            $user->isAdmin()
            ? Response::allow()
            : Response::deny("You are not allowed to delete this job.");
    }
}
