<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::id())->orderBy('issue_date', 'desc')->paginate(10);
        return view('users.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('users.invoices.create', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_address' => 'required|string',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            // 'payment_method_id' => 'nullable|exists:payment_methods,id', // Jika user bisa pilih saat buat
        ]);

        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'invoice_number' => Invoice::generateInvoiceNumber(), // Gunakan helper
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_address' => $request->client_address,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'total_amount' => $request->total_amount,
            'description' => $request->description,
            'payment_status' => 'unpaid',
            // 'payment_method_id' => $request->payment_method_id,
        ]);

        return redirect()->route('user.invoices.index')->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(Invoice $invoice)
    {
        // Pastikan invoice milik user yang login
        if ($invoice->user_id !== Auth::id()) {
            abort(403);
        }
        return view('users.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id() || $invoice->payment_status === 'paid') {
            // Tidak bisa edit jika bukan milik user atau sudah dibayar
            return redirect()->route('user.invoices.index')->with('error', 'Invoice tidak dapat diedit.');
        }
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        return view('users.invoices.edit', compact('invoice', 'paymentMethods'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id() || $invoice->payment_status === 'paid') {
            return redirect()->route('users.invoices.index')->with('error', 'Invoice tidak dapat diupdate.');
        }

        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_address' => 'required|string',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'total_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $invoice->update($request->only([
            'client_name', 'client_email', 'client_address',
            'issue_date', 'due_date', 'total_amount', 'description'
        ]));

        return redirect()->route('user.invoices.index')->with('success', 'Invoice berhasil diupdate.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->user_id !== Auth::id() || $invoice->payment_status === 'paid') {
            return redirect()->route('users.invoices.index')->with('error', 'Invoice tidak dapat dihapus.');
        }
        $invoice->delete();
        return redirect()->route('user.invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }
}