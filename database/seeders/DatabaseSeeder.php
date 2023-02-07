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
			'full_name' => 'admin',
			'password' => bcrypt('12345'),
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
		]);
    }
}
