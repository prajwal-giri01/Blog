<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin')
        ]);
        $user1->assignRole('admin');

        $user2 = User::create([
            'name' => 'author',
            'email' => 'author@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('author')
        ]);
        $user2->assignRole('author');
    }
}
