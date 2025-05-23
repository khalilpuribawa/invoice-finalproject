<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Pastikan ini diimpor
use Carbon\Carbon; // Diimpor untuk format tanggal bulan

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Stats Cards
        $totalRevenue = Invoice::where('payment_status', 'paid')->sum('total_amount');
        $totalUsers = User::where('role', 'user')->count();
        $totalInvoices = Invoice::count();
        $unpaidInvoices = Invoice::whereIn('payment_status', ['unpaid', 'pending'])->count();

        // 2. Data untuk Faktur Terbaru
        $recentInvoices = Invoice::with('user')
                                ->latest('created_at')
                                ->take(5)
                                ->get();

        // 3. Data untuk Aktivitas Terbaru
        $recentActivities = $recentInvoices->map(function ($invoice) {
            $currentStatus = $invoice->payment_status ?? 'unknown';
            $description = 'Status faktur: ' . ucfirst(str_replace('_', ' ', $currentStatus));
            if (!empty($invoice->description)) {
                $description = $invoice->description;
            }

            return (object) [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'user' => $invoice->user,
                'customer_name' => $invoice->customer_name ?? ($invoice->user->name ?? null),
                'status' => $currentStatus,
                'total_amount' => $invoice->total_amount,
                'created_at' => $invoice->created_at,
                'description' => $description,
            ];
        });

        // 4. Data untuk Chart Pendapatan Bulanan (Tahun ini, semua 12 bulan)
        $currentYear = date('Y');
        $revenueByMonthData = Invoice::select(
                DB::raw('SUM(total_amount) as total_revenue'),
                DB::raw("MONTH(created_at) as month_number")
            )
            ->where('payment_status', 'paid') // PASTIKAN NAMA KOLOM INI BENAR
            ->whereYear('created_at', $currentYear)
            ->groupBy('month_number')
            ->orderBy('month_number', 'asc')
            ->get()
            ->keyBy('month_number');

        $allMonthLabels = [];
        $filledDataValues = [];

        for ($m = 1; $m <= 12; $m++) {
            $allMonthLabels[] = Carbon::create()->month($m)->format('M');
            $revenueForMonth = $revenueByMonthData->get($m);
            $filledDataValues[] = $revenueForMonth ? (float)$revenueForMonth->total_revenue : 0;
        }

        $chartData = [
            'labels' => $allMonthLabels,
            'data'   => $filledDataValues,
        ];

        // Untuk Debugging Chart jika masih kosong:
        // dd($chartData, $revenueByMonthData->toArray());

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalUsers',
            'totalInvoices',
            'unpaidInvoices',
            'recentInvoices',
            'recentActivities',
            'chartData' // Mengirimkan data chart ke view
        ));
    }
}