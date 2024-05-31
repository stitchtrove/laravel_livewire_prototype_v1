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
        Schema::create('performances', function (Blueprint $table) {
            $table->id('id');
            $table->string('show_id');
            $table->date('start_datetime');
            $table->date('end_datetime')->nullable();
            $table->string('venue');
            $table->string('screen');
            $table->string('availability_number');
            $table->string('availability');
            $table->string('sales_status');
            $table->string('pricing');
            $table->string('on_sale_date');
            $table->string('additional_info_url');
            $table->string('instance');
            $table->string('strand');
            $table->string('accessibility')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};
