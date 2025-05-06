<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produto;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Produto::count(),
            'total_revenue' => Produto::sum('total_amount'),
        ];

        $recent_orders = Produto::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recent_orders'));
    }
}