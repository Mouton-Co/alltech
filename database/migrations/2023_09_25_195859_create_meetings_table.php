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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('objective')->nullable();
            $table->text('marketing_requirements')->nullable();
            $table->boolean('added_to_teams')->default(false);
            $table->foreignId('contact_id')->constrained('contacts');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('company_type_id')->constrained('company_types');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
