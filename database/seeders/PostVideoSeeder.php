<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $videos = \App\Models\Video::get();
        $posts = \App\Models\Post::get();

        foreach ($posts as $post){
            $tag = \App\Models\Tag::get()->random()->first();
            $post->tags()->save($tag);
        }
        foreach ($videos as $video){
            $tag = \App\Models\Tag::get()->random->first();
            $video->tags()->save($tag);
        }
    }
}
