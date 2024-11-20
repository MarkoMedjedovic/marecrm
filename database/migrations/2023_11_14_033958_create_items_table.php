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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->string('type')->default("cash");
            $table->integer('loan_amount')->default(0);
            $table->integer('property_value')->default(0);
            $table->integer('down_payment')->default(0);

            $table->string('memo')->nullable();
            $table->integer('price')->default(0);
            $table->boolean('is_selling')->default(true);

            $table->integer('customer_id')->default(0);
            $table->integer('user_id')->default(0);

            $table->unique(['customer_id','type']);

            $table->timestamps();
 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
