<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('bank_id')->nullable()->constrained()
                ->onUpdate('cascade')->onDelete('set null');
            $table->string('account_name');
            $table->string('account_number');
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
        Schema::dropIfExists('business_banks');
    }
}
