<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Gunakan `php artisan migrate:fresh --seed` untuk mengulang dari awal.
     */
    public function run(): void
    {
        $this->call([
            GenerateDataPenduduk::class,
            UserDataGenerate::class,
            DataPengantarSeeder::class,
            KritikSaranSeeder::class,
        ]);
    }
}
