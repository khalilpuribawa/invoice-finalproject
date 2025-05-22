<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentInvoices = Invoice::where('user_id', $user->id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
        return view('users.dashboard', compact('user', 'recentInvoices'));
    }
}