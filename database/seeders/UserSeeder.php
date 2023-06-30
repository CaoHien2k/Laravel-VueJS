<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->avatar = 'avatar'.$i.'.png';
            $user->username = 'user_'.$i;
            $user->name = $faker->name();
            $user->email = $faker->unique()->email();
            $user->password = Hash::make('12345'); 
            $user->department_id = 1; 
            $user->status_id = rand(1,2); 
            $user->save();
        }

        $user = new User();
        $user->avatar = 'avatar'.$i.'.png';
        $user->username = 'admin';
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('admin'); 
        $user->department_id = 1; 
        $user->status_id = 1; 
        $user->save();
    }
}
