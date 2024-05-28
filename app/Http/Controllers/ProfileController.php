<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\Roles\ListRole;
use App\Services\Users\UpdateUser;
use App\Services\Users\DeleteUser;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'data' => new UserResource($request->user()),
            'roles' => $this->getSelectRoles(),
            'toast' => session('toast'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['avatar'] = $this->storeAvatar($request);
        UpdateUser::call($request->user()->id, $data);

        return redirect()->route('profile.edit')->with('toast', 'Profile updated.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        DeleteUser::call($user->id);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function storeAvatar(ProfileUpdateRequest $request)
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

        return $request->file('avatar')->storePublicly('public/avatars');
    }

    protected function getSelectRoles()
    {
        return collect(ListRole::call())->map(fn($r) => [ 'value' => $r->name, 'text' => $r->name ]);
    }
}
