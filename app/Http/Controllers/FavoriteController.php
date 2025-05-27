<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class FavoriteController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display user's favorite products
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('produto')->paginate(12);
        return view('favoritos.index', compact('favorites'));
    }
    
    /**
     * Toggle favorite status for a product
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id'
        ]);
        
        $user = Auth::user();
        $produtoId = $request->produto_id;
        
        // Check if already favorited
        $favorito = Favorite::where('user_id', $user->id)
                           ->where('produto_id', $produtoId)
                           ->first();
        
        if ($favorito) {
            // Already favorited, so remove
            $favorito->delete();
            $message = 'Produto removido dos favoritos';
        } else {
          // Not favorited, so add
            Favorite::create([
                'user_id' => $user->id,
                'produto_id' => $produtoId
            ]);
            $message = 'Produto adicionado aos favoritos';
        }
        
        // Redirect back with message
        return back()->with('success', $message);
    }
}

