<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // default role
        DB::table('role')->insert([
            'portal_id' => 1,
            'role_nm' => 'developer',
            'role_desc' => 'Role Untuk developer',
            'default_page' => 'base/manage/home',
            'created_at' =>  Carbon::today(),
            'updated_at' =>  Carbon::today(),
        ]);
        // default role user
        DB::table('user_role')->insert([
            'user_login_id' => 1,
            'role_id' => 1,
            'created_at' =>  Carbon::today(),
            'updated_at' =>  Carbon::today(),
        ]);
    }
}
