<?php

namespace Database\Seeders;

use App\Enums\WhatsappSessionServerStatus;
use App\Enums\WhatsappSessionStatus;
use App\Models\User;
use App\Models\WhatsappSessionServer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // this test server is used for testing purposes
        WhatsappSessionServer::updateOrCreate(
            [
                'name' => 'default'
            ],
            [
                'host' => 'whatsapp-api-2.azurewebsites.net',
                'port' => '443',
                'secret' => null,
                'status' => WhatsappSessionServerStatus::ACTIVE,
            ]
        );
    }
}
