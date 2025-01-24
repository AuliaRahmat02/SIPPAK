<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\UserSeeder;
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
        // $this->call([UserSeeder::class]);

        // menjalankan tabel seeder seperti di bawah seperti pegawai dan lain sebagainya
        // $this->call([pegawaiseed::class]);
        $this->call([UserSeeder::class]);
        $this->call([KontrolModelSeeder::class]);
    }
}
