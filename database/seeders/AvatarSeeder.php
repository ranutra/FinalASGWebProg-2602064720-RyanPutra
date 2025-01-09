<?php

namespace Database\Seeders;

use App\Models\Avatar as AvatarModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvatarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            'Chill Guy',
            'Vergillius',
            'Duke Erisia',
        ];

        for ($i=1; $i <= 3; $i++) { 
            AvatarModel::create([
                'name' => $name[$i - 1],
                'price' => rand(50, 100000),
                'imagepath' => '/assets/img/avatar/'.$i.'.jpg'
            ]);
        }
    }
}
