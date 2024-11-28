<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pengaduan;
use App\Models\StatusPengaduan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            "name" => "Administrator",
            "username" => "admin",
            "email" => "admin@smkn17.id",
            "password" => bcrypt("Telkomdso123"),
            "level" => "admin",
        ]);

        User::create([
            "name" => "Hidayatullah",
            "username" => "hidayatoc",
            "email" => "dayat@gmail.com",
            "password" => bcrypt("dayat123"),
            "level" => "user"
        ]);

    }
}
