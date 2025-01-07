<?php

namespace Modules\Users\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Users\Http\Requests\ProfileUpdateRequest;
use Modules\Users\Http\Resources\UserResource;
use Modules\Core\Services\ListEntity;
use Modules\Users\Services\DeleteUser;
use Modules\Users\Services\UpdateUser;
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
            'roles' => ListEntity::call('role'),
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
        if ($request->file('avatar') == null) {
            return null;
        }

        return $request->file('avatar')->storePublicly('public/avatars');
    }
}
