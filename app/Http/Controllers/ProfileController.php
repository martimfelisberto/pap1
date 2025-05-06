<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Produto;

class ProfileController extends Controller
{
    /**
     * Display the user's profile with their products and favorites
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        
        $produtos = Produto::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        $favoritos = [];
        if (Auth::check()) {
            $favoritos = Auth::user()->favoriteProdutos()->pluck('produto_id')->toArray();
        }

        return view('profile.show', [
            'user' => $user,
            'produtos' => $produtos,
            'favoritos' => $favoritos
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $produtos = Produto::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('profile.edit', [
            'user' => $user,
            'produtos' => $produtos,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        // Handle additional user preferences
        if ($request->has('telefone')) {
            $user->telefone = $request->telefone;
        }

        if ($request->has('bio')) {
            $user->bio = $request->bio;
        }

        if ($request->has('preferred_categories')) {
            $user->preferred_categories = $request->preferred_categories;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account and associated products.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete user's products and their associated images
        $produtos = Produto::where('user_id', $user->id)->get();
        foreach ($produtos as $produto) {
            if ($produto->imagem) {
                $imagens = json_decode($produto->imagem, true);
                foreach ($imagens as $imagem) {
                    Storage::disk('public')->delete($imagem);
                }
            }
            $produto->delete();
        }

        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display user's favorite products
     */
    public function favorites(): View
    {
        $user = Auth::user();
        $favoritos = $user->favoriteProdutos()->paginate(12);

        return view('profile.favorites', [
            'favoritos' => $favoritos
        ]);
    }
}