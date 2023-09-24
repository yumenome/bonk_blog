<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //insert datas into data-table

        \App\Models\Article::factory(20)->create();
        \App\Models\Comment::factory(30)->create();
        // \App\Models\Star::factory(20)->create();

        $names = ["love", "music", "fontend", "backend", "fullstack"];
        foreach($names as $name){
            \App\Models\Category::create(["name" => $name]);
        }

        \App\Models\User::factory()->create([
            "name" =>"yume",
            "email" => "yume@gmail.com",
        ]);
        \App\Models\User::factory()->create([
            "name" =>"nome",
            "email" => "nome@gmail.com",
        ]);

    }
}
