<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('business_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->decimal('fee', 10, 2)->nullable();
            $table->decimal('charge', 10, 2)->nullable();
            $table->decimal('payout', 10, 2)->nullable();
            $table->decimal('rating', 1, 1)->nullable();
            $table->foreignId('status_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
