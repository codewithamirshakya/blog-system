<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** Disable the observer on seeder */
        /** @var  $dispatcher */
        $dispatcher = Post::getEventDispatcher();

        Post::unsetEventDispatcher();
        Post::factory()->count(20)->create();
        Post::setEventDispatcher($dispatcher);
    }
}
