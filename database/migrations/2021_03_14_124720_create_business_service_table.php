<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('service_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
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
        Schema::dropIfExists('business_service');
    }
}
