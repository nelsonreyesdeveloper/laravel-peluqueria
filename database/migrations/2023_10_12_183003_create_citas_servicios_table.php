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
        Schema::create('citas_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('cantidad');
            $table->float('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas_servicios');
    }
};
