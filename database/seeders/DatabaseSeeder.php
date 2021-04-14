<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         ///\App\Models\Message::factory(350)->create();

         
        \App\Models\Message::factory(20)->create();
         
    }
}
