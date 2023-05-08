<?php

use App\ORM\Enums\ClientGenderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * category,firstname,lastname,email,gender,birthDate

     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->enum('gender', ClientGenderEnum::values());
            $table->date('birth_date');
            $table->timestamps();

            $table->index('category');
            $table->index('gender');
            $table->index('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
