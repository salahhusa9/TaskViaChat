<?php

use App\Models\WhatsappSessionServer;
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
        Schema::create('whatsapp_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // id of session in server, ex: 1234567890@c.us
            $table->string('session_name')->nullable(); // name of session in server, ex: defualt
            $table->string('session_push_name')->nullable(); // push name of session, ex: salah eddine bendyab
            $table->string('phone_number')->nullable(); // phone number of session, ex: 1234567890
            $table->string('status')->nullable();
            $table->foreignIdFor(WhatsappSessionServer::class);
            $table->string('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_sessions');
    }
};
