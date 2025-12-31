<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seed homepage data
        $this->call([
            BannerSeeder::class,
            NewsSeeder::class,
            NotificationSeeder::class,
            DocumentSeeder::class,
            TeacherSeeder::class,
            StudentLoginSeeder::class, // Tạo tài khoản login cho học sinh
            TeacherLoginSeeder::class, // Tạo tài khoản login cho giáo viên
        ]);
    }
}
