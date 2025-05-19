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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile with their products and favorites
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        
        
        return view('profile.show', [
            'user' => $user,
            
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
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
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'max:2048']
        ]);

        $user = $request->user();
        
        if (!$user) {
            return back()->with('error', 'You must be logged in to update your profile photo.');
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
            $user->save();
        }

        return back()->with('success', 'Foto de perfil atualizada com sucesso.');
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
     * Display user's products
     */
    public function produtos(Request $request)
    {
        $user = $request->user();
        $produtos = $user->produtos()->latest()->paginate(12);
        return view('profile.produtos', compact('produtos'));
    }

    /**
     * Display user's sales
     */
    public function vendas(Request $request)
    {
        $user = $request->user();
        $vendas = $user->vendas()->latest()->paginate(12);
        return view('profile.vendas', compact('vendas'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('status', 'Senha atualizada com sucesso.');
    }
    /**
     * Display user's favorite products
     */
}