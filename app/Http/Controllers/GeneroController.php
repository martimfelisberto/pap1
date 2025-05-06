<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    public function show($slug)
    {
        $genero = Genero::where('slug', $slug)->firstOrFail();
        $produtos = $genero->produtos()->paginate(12);

        return view('generos.show', compact('genero', 'produtos'));
    }
}