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
        
    }

    /**
     * Display user's favorite products
     */

     public function index()
    {
        
    }


    
}

