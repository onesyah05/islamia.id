<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UstadzDetail;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Bookmark;
use App\Models\Notification;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

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

        $faker = Faker::create('id_ID');

        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Ustadz
        $ustadz = User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ustadz@example.com',
            'password' => Hash::make('password'),
            'role' => 'ustadz',
        ]);
        UstadzDetail::create([
            'user_id' => $ustadz->id,
            'nama_lengkap' => 'Ustadz Ahmad',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Pesantren No. 1',
            'foto' => null,
            'bio' => 'Ustadz dan pengajar di pesantren.',
            'keahlian' => 'Fiqih, Hadits',
            'status' => 'aktif',
        ]);

        // User
        $user = User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Categories
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $categories[] = Category::create([
                'name' => $faker->word,
            ]);
        }

        // Questions
        $questions = [];
        for ($i = 1; $i <= 200; $i++) {
            $title = $faker->sentence;
            $q = Question::create([
                'user_id' => $user->id,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . $i,
                'content' => $faker->paragraph,
                'is_answered' => $faker->boolean,
                'views' => $faker->numberBetween(0, 500),
            ]);
            // Attach random categories
            $q->categories()->attach($faker->randomElements(array_column($categories, 'id'), rand(1, 2)));
            $questions[] = $q;
        }

        // Answers
        foreach ($questions as $question) {
            if ($faker->boolean(80)) { // 80% questions answered
                Answer::create([
                    'question_id' => $question->id,
                    'user_id' => $ustadz->id,
                    'content' => $faker->paragraph,
                ]);
            }
        }

        // Bookmarks
        for ($i = 0; $i < 5; $i++) {
            Bookmark::create([
                'user_id' => $user->id,
                'question_id' => $faker->randomElement($questions)->id,
            ]);
        }

        // Notifications
        for ($i = 0; $i < 5; $i++) {
            Notification::create([
                'user_id' => $user->id,
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'is_read' => $faker->boolean,
            ]);
        }
    }
}
