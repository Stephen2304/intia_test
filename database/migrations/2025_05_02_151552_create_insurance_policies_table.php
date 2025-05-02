<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('insurance_type_id');
            $table->string('policy_number')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('coverage_amount', 15, 2);
            $table->decimal('annual_premium', 15, 2);
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('insurance_type_id')->references('id')->on('insurance_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_policies');
    }
}; 