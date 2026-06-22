<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load('profile');

        return view('profiles.index', [
            'user' => $user,
            'profile' => $user->profile,
        ]);
    }

    public function show(Request $request, UserProfile $profile): View
    {
        abort_unless($profile->user_id === $request->user()->id, 403);

        return view('profiles.show', [
            'user' => $request->user(),
            'profile' => $profile,
        ]);
    }
}
