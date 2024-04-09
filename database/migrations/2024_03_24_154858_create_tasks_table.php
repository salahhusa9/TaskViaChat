<?php

use App\Models\Number;
use App\Models\TaskStatus;
use App\Models\WhatsappMessage;
use App\Models\WhatsappMessageReaction;
use App\Models\WhatsappSession;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->foreignIdFor(TaskStatus::class)->nullable();

            $table->foreignIdFor(WhatsappSession::class)->nullable();
            $table->foreignIdFor(WhatsappMessage::class)->nullable();

            $table->string('whatsapp_chat_id')->nullable(); // 1111111111@c.us

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
