<?php

namespace App\Policies\Contracts;

//Interface to determine whether an authenticated user is Admin or Student
interface UserInterface
{
    public function isAdmin();
}
