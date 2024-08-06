<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeader::class);
        $this->call(PagesTableSeader::class);
        $this->call(PostCategoriesTableSeader::class);
        $this->call(PostsTableSeader::class);
        $this->call(PostTagsTableSeader::class);
        $this->call(TagsTableSeader::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(AdminSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
