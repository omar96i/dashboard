<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('memberships')->insert([
            'name' => 'admin',
            'description' => 'descripcion...',
            'cost' => 0,
            'status' => 'activo',
        ]);
    }
}
