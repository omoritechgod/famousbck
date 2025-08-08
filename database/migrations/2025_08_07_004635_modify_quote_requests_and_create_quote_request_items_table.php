<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify quote_requests table
        Schema::table('quote_requests', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('product_id');
            $table->string('urgency')->nullable();
            $table->string('status')->default('pending');
        });

        // Create quote_request_items
        Schema::create('quote_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_request_id')->constrained()->onDelete('cascade');
            $table->string('product_code')->nullable();
            $table->text('product_description')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('price')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
