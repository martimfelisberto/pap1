<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a product
     */
    public function toggle(Request $request, $produtoId)
    {
        $produto = Produto::findOrFail($produtoId);
        $user = Auth::user();

        // Check if product is already favorited
        $isFavorited = $user->favoriteProdutos()->where('produto_id', $produto->id)->exists();

        if ($isFavorited) {
            // Remove from favorites
            $user->favoriteProdutos()->detach($produto->id);
            $isFavorited = false;
        } else {
            // Add to favorites
            $user->favoriteProdutos()->attach($produto->id);
            $isFavorited = true;
        }

        if ($request->ajax()) {
            return response()->json([
                'favorited' => $isFavorited,
                'count' => $produto->favorites()->count()
            ]);
        }

        return redirect()->back()->with('success', $isFavorited ? 
            'Produto adicionado aos favoritos!' : 
            'Produto removido dos favoritos!');
    }

    /**
     * Display user's favorite products
     */
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoriteProdutos()->paginate(12);

        return view('favorites.index', compact('favorites'));
    }
}

