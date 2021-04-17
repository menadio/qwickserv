<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('business_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('booking_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('set null');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('reference');
            $table->foreignId('status_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
