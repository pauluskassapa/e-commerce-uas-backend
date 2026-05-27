<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profiles.index', [
            'profiles' => UserProfile::with('user')->latest()->get(),
        ]);
    }

    public function show(UserProfile $profile): View
    {
        return view('profiles.show', compact('profile'));
    }
}
