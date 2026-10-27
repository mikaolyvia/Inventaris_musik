<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;

class DemoSeeder extends Seeder
{
    /**
     * Seed the application with minimal demo data.
     *
     * Creates only users and basic categories for a clean start.
     * Run with: php artisan db:seed --class=DemoSeeder
     */
    public function run(): void
    {
        // ============================================================
        // USERS
        // ============================================================
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Staff Toko',
            'email'    => 'staff@admin.com',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);

        // ============================================================
        // CATEGORIES
        // ============================================================
        $categories = [
            ['name' => 'Gitar',                'description' => 'Gitar akustik, elektrik, dan klasik.'],
            ['name' => 'Piano & Keyboard',      'description' => 'Piano digital, keyboard, dan synthesizer.'],
            ['name' => 'Drum & Perkusi',         'description' => 'Drum akustik, elektrik, cajon, dan perkusi lainnya.'],
            ['name' => 'Bass',                   'description' => 'Bass elektrik dan akustik.'],
            ['name' => 'Biola & String',         'description' => 'Biola, ukulele, dan alat musik gesek/petik lainnya.'],
            ['name' => 'Alat Tiup',              'description' => 'Saxophone, flute, harmonika, dan alat tiup lainnya.'],
            ['name' => 'Aksesoris Musik',        'description' => 'Senar, pick, tuner, stand, kabel, dan aksesoris lainnya.'],
            ['name' => 'Audio & Sound System',   'description' => 'Speaker, mixer, microphone, dan peralatan audio.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
