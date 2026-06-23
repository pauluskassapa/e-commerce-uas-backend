<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Models\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load(['profile', 'addresses']);

        return view('profiles.index', [
            'user' => $user,
            'profile' => $user->profile,
            'addresses' => $user->addresses,
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

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $profile = $request->user()->profile;

        if ($profile) {
            $profile->update($validated);
        }

        $request->user()->addresses()->updateOrCreate(
            ['is_default' => true],
            [
                'label' => 'Alamat Utama',
                'address' => $validated['address'],
                'is_default' => true,
            ]
        );

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Profil dan alamat utama berhasil diperbarui.');
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $request->user()->addresses()->create([
            'label' => $validated['label'],
            'address' => $validated['address'],
            'is_default' => false,
        ]);

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Alamat baru berhasil ditambahkan.');
    }

    public function updateAddress(Request $request, UserAddress $address): RedirectResponse
    {
        abort_unless($address->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
        ]);

        $address->update($validated);

        return redirect()
            ->route('profiles.index')
            ->with('success', 'Alamat berhasil diperbarui.');
    }
}
