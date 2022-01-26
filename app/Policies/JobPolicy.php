<?php

namespace App\Policies;

use App\Models\Job;
use App\Policies\Contracts\UserInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Checks if the authenticated user has permissions to create a new Job.
     */
    public function create(UserInterface $user)
    {
        return !$user->isAdmin()
            ? Response::allow()
            : Response::deny("Only a Student is allowed to create a job.");
    }

    /**
     * Checks if the authenticated user has permissions to view all the jobs in the system.
     */
    public function viewAll(UserInterface $user)
    {
        return !$user->isAdmin() || $user->isAdmin()
            ? Response::allow()
            : Response::deny(
                "Students and Admins are allowed to see job listings.",
            );
    }

    /**
     * Checks if the authenticated user has permissions to view a specific job in the system.
     */
    public function viewAny(UserInterface $user)
    {
        return !$user->isAdmin() || $user->isAdmin()
            ? Response::allow()
            : Response::deny("Students and Admins are allowed view jobs.");
    }

    /**
     * Checks if the authenticated user has permissions to edit and update a job.
     */
    public function editAndUpdate(UserInterface $user, Job $job)
    {
        return !$user->isAdmin() && $job->user->is($user)
            ? Response::allow()
            : Response::deny("You are not allowed to edit or update this job.");
    }

    /**
     * Checks if the authenticated user has permissions to delete a job.
     */
    public function destroy(UserInterface $user, Job $job)
    {
        return (!$user->isAdmin() && $job->user->is($user)) || $user->isAdmin()
            ? Response::allow()
            : Response::deny("You are not allowed to delete this job.");
    }

    /**
     * Checks if the authenticated user has permissions to approve or disapprove a job.
     */
    public function approveAndDisapproveJobs(UserInterface $user)
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny(
                "Only Admins are allowed to approve or disapprove jobs.",
            );
    }
}
