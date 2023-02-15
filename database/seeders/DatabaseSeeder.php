<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			'email' => 'admin@hotmail.com',
			'password' => bcrypt('12345'),
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
		]);

        DB::table('personal_information')->insert([
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'user_id' => 1,
            'id_card' => 1234,
            'full_name' => 'omar',
            'address' => 'dasasd',
            'landline' => '1231',
            'country_code' => '123',
            'phone' => '321312',
            'city' => 'hola',
            'department' => 'hola',
		]);

        DB::table('business')->insert([
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'name' => 'empresa 1',
            'country' => 'co',
            'time_zone' => 'co',
            'path_icon' => 'hola',
            'description' => 'hola',
		]);
    }
}
