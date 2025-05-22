<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class AdminPaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('name')->paginate(10);
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'details' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'details' => $request->details,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,'.$paymentMethod->id,
            'details' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'details' => $request->details,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diupdate.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        // Perlu dicek apakah metode ini sedang digunakan oleh invoice
        if ($paymentMethod->invoices()->where('payment_status', 'paid')->exists()) {
             return redirect()->route('admin.payment-methods.index')->with('error', 'Metode pembayaran tidak dapat dihapus karena masih digunakan oleh invoice terbayar.');
        }
        // Jika ada invoice 'unpaid' yang menggunakan ini, set payment_method_id nya jadi null
        $paymentMethod->invoices()->update(['payment_method_id' => null]);

        $paymentMethod->delete();
        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}