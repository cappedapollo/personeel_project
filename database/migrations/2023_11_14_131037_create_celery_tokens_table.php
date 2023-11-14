<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celery_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('access_token');
            $table->integer('expires_in');
            $table->string('token_type')->default('Bearer');
            $table->string('userId');
            $table->text('refresh_token')->nullable();
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
        Schema::dropIfExists('celery_tokens');
    }
};
