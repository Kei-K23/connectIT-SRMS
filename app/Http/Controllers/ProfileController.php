<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if ($user->administrator) {
            return view('profile.admin-edit', [
                'user' => $request->user(),
            ]);
        } elseif ($user->student) {
            return view('profile.student-edit', [
                'user' => $request->user(),
            ]);
        } elseif ($user->instructor) {
            return view('profile.instructor-edit', [
                'user' => $request->user(),
            ]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'address' => ['string', 'max:255', 'nullable'],
                'email' => ['required', 'string', 'email'],
                'phone_number' => ['string', 'nullable'],
                'image' => ['image', 'nullable'],
            ]
        );

        if ($request->hasFile('image')) {
            // Store the image in the storage
            $fileName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public', $fileName);

            $validatedData['image'] = $fileName;
        }

        $request->user()->update($validatedData);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
