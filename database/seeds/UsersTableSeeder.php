<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => '赤澤拓実',
                'mail' => 'akazawa@mail.com',
                'password' => Hash::make('awazaka123'),
                'bio' => 'SNS製作中です。',
                'created_at' => '2023-5-5 10:10:30',
                'updated_at' => '2023-7-5 10:10:30',
            ],
            [
                'username' => '伊藤祐樹',
                'mail' => 'itou@mail.com',
                'password' => Hash::make('uoti123'),
                'bio' => 'SNS製作中です。',
                'created_at' => '2023-5-5 10:15:30',
                'updated_at' => '2023-7-5 10:15:30',
            ],
            [
                'username' => '佐藤学',
                'mail' => 'satou@mail.com',
                'password' => Hash::make('uotas123'),
                'bio' => 'SNS製作中です。',
                'created_at' => '2023-5-5 10:20:30',
                'updated_at' => '2023-7-5 10:20:30',
            ],
            [
                'username' => '藤田哲平',
                'mail' => 'fujita@mail.com',
                'password' => Hash::make('atijuf123'),
                'bio' => 'SNS製作中です。',
                'created_at' => '2023-5-5 10:25:30',
                'updated_at' => '2023-7-5 10:25:30',
            ],
            [
                'username' => '田代真由',
                'mail' => 'tashiro@mail.com',
                'password' => Hash::make('orihsat123'),
                'bio' => 'SNS製作中です。',
                'created_at' => '2023-5-5 10:30:30',
                'updated_at' => '2023-7-5 10:30:30',
            ],
        ]);
    }
}
