<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('wishlist_id')->nullable()->constrained('wishlists')->nullOnDelete();
            $table->date('check_in');
            $table->date('check_out');
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->string('payment_method')->nullable(); // qris, credit_card, cash, admin
            $table->string('status')->default('pending'); // pending, active, completed, cancelled
            $table->boolean('created_by_admin')->default(false);
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
