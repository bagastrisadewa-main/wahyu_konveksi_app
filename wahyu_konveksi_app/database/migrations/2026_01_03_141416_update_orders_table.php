<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('customer_id')->after('id');
                $table->string('order_code', 50)->after('customer_id');
                $table->string('status', 30)->default('draft')->after('order_code');
                $table->text('note')->nullable()->after('status');

                $table->integer('subtotal')->after('total_item');
                $table->timestamp('updated_status_at')->nullable();

                $table->foreign('customer_id')
                    ->references('id')
                    ->on('customers')
                    ->cascadeOnDelete();

                // ❌ JANGAN rename transaction_time
                // ❌ JANGAN drop created_at
                $table->dropColumn(['kasir_id', 'payment_method']);
            });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropForeign(['customer_id']);

            $table->dropColumn([
                'customer_id',
                'order_code',
                'status',
                'note',
                'subtotal',
                'updated_status_at'
            ]);

            $table->renameColumn('created_at', 'transaction_time');
            $table->unsignedBigInteger('kasir_id');
            $table->string('payment_method');
        });
    }
};
