<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Invoice::where('payment_status', 'paid')->sum('total_amount');
        $totalUsers = User::where('role', 'user')->count();
        $totalInvoices = Invoice::count();
        $unpaidInvoices = Invoice::where('payment_status', 'unpaid')->count();

        return view('admin.dashboard', compact('totalRevenue', 'totalUsers', 'totalInvoices', 'unpaidInvoices'));
    }
}