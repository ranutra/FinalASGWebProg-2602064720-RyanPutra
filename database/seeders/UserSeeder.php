<?php

namespace Database\Seeders;

use App\Models\User as UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 5; $i++) { 
            UserModel::create([
                'name' => 'User '.$i,
                'email' => 'user'.$i.'@gmail.com',
                'password' => 'user123',
                'gender' => rand(0, 2) == 0 ? 'Female' : 'Male',
                'hobbies' => rand(0, 2) == 0 ? json_encode(explode(',', 'Sports, Music, Video Games')) : json_encode(explode(',', 'Sports, Music, Video Games')),
                'instagram_username' => 'test',
                'mobile_number' => '081369251040'
            ]);
        }
    }
}
