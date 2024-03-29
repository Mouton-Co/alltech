<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_crons', function (Blueprint $table) {
            $table->id();
            $table->string('day')->nullable();
            $table->integer('hour')->nullable();
            $table->string('to')->nullable();
            $table->string('subject')->nullable();
            $table->text('filter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_crons');
    }
};
