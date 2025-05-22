<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_payment_methods_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Bank Transfer, Credit Card
            $table->text('details')->nullable(); // e.g., Account number, gateway info (bisa JSON)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};