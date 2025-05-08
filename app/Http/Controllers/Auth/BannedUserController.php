<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannedUserController extends Controller
{
    /**
     * Display the banned user page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check() || !Auth::user()->is_banned) {
            return redirect()->route('/');
        }
        
        return view('auth.banned');
    }
}
