<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('user', 'paymentMethod')->orderBy('issue_date', 'desc');

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $invoices = $query->paginate(10);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('admin.invoices.index', compact('invoices', 'paymentMethods'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid',
            'payment_method_id' => 'required_if:payment_status,paid|nullable|exists:payment_methods,id',
        ]);

        $invoice->payment_status = $request->payment_status;
        if ($request->payment_status === 'paid') {
            $invoice->paid_at = now();
            $invoice->payment_method_id = $request->payment_method_id;
        } else {
            $invoice->paid_at = null;
            $invoice->payment_method_id = null; // Kosongkan metode jika belum bayar
        }
        $invoice->save();

        return redirect()->route('admin.invoices.index')->with('success', 'Status pembayaran invoice berhasil diupdate.');
    }
}