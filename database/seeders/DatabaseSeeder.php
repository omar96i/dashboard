<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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
        DB::table('business')->insert([
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'name' => 'empresa 1',
            'country' => 'co',
            'time_zone' => 'co',
            'path_icon' => 'hola',
            'description' => 'hola',
		]);

        DB::table('users')->insert([
			'email' => 'admin@hotmail.com',
			'password' => bcrypt('12345'),
            'business_id' => 1,
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
            'iso' => 'CO',
            'country_code' => '57',
            'phone' => '3225402128',
            'city' => 'hola',
            'department' => 'hola',
		]);
        $role = Role::create(['name' => 'super.admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'cobrador']);
        $user = User::find(1);

        $user->assignRole($role);


    }
}
