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
        Schema::create('whatsapp_message_reactions', function (Blueprint $table) {
            $table->id();
            $table->string('message_id');
            $table->string('reaction');

            $table->string('from');      // 11111111111@c.us
            $table->string('to');       // 11111111111@c.us

            $table->string('session_id');
            $table->string('session_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_message_reactions');
    }
};
