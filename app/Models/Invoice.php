<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'client_name',
        'client_email',
        'client_address',
        'issue_date',
        'due_date',
        'total_amount',
        'payment_status',
        'payment_method_id',
        'paid_at',
        'description',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // Helper untuk generate nomor invoice unik (contoh sederhana)
    public static function generateInvoiceNumber()
    {
        // Format: INV-YYYYMMDD-XXXX (XXXX adalah nomor urut acak atau sekuensial)
        $date = now()->format('Ymd');
        $latestInvoice = self::latest('id')->first();
        $nextId = $latestInvoice ? substr($latestInvoice->invoice_number, -4) + 1 : 1;
        return 'INV-' . $date . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
    }
}