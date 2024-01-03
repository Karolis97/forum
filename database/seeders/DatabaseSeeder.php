<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $posts = Post::factory(150)
            ->has(Comment::factory(15)->recycle($users))
            ->recycle($users)
            ->create();

        User::factory()
            ->has(Post::factory(30))
            ->has(Comment::factory(90)->recycle($posts))
            ->create([
                'name' => 'Karolis',
                'email' => 'karolis@example.com',
                'password' => Hash::make('password'),
            ]);
    }
}
