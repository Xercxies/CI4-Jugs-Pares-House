<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index(): string
    {
        return view('user/landing');
    }

    public function signIn(): string
    {
        return view('user/sign-in');
    }

    public function roadmap(): string
    {
        return view('user/roadmap');
    }

    public function moodboard(): string
    {
        return view('user/moodboard');
    }
}
