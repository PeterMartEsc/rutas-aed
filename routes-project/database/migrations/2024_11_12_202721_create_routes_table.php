<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/**
 * @author Nabil Leon Alvarez <@nalleon>
 * @author Pedro Martin Escuela <@PeterMartEsc>
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('location');
            $table->integer('distance')->nullable();
            $table->timestamp('date_route')->useCurrent();
            $table->integer('difficulty')->nullable();
            $table->boolean('pets_allowed')->default(false);
            $table->boolean('vehicle_needed')->default(false);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users', 'id');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
