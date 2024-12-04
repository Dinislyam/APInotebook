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
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); // ФИО
            $table->string('company')->nullable(); // Компания
            $table->string('phone'); // Телефон
            $table->string('email'); // Email
            $table->date('birth_date')->nullable(); // Дата рождения
            $table->string('photo_path')->nullable(); // Фото
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notebooks');
    }
};
