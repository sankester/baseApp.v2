<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // set data
        $data = [
            [
                'portal_id' => 1,
                'parent_id' => 0,
                'menu_title' => 'Home',
                'menu_desc' => 'Home Developer',
                'menu_url' => 'base/manage/home',
                'menu_nomer' => 1,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => 'mdi mdi-dashboard',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ], [
                'portal_id' => 1,
                'parent_id' => 0,
                'menu_title' => 'User',
                'menu_desc' => 'Manajemen User',
                'menu_url' => 'base/manage/user',
                'menu_nomer' => 2,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => 'mdi mdi-account',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ],[
                'portal_id' => 1,
                'parent_id' => 0,
                'menu_title' => 'Role & Permission',
                'menu_desc' => 'Role & Permission',
                'menu_url' => '#',
                'menu_nomer' => 3,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => 'mdi mdi-account-settings-variant',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ],[
                'portal_id' => 1,
                'parent_id' => 3,
                'menu_title' => 'Role',
                'menu_desc' => 'Manajemen Role',
                'menu_url' => 'base/manage/role',
                'menu_nomer' => 1,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => '',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ],[
                'portal_id' => 1,
                'parent_id' => 3,
                'menu_title' => 'Permission',
                'menu_desc' => 'Manajemen Permission',
                'menu_url' => 'base/manage/permission',
                'menu_nomer' => 2,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => '',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ],[
                'portal_id' => 1,
                'parent_id' => 0,
                'menu_title' => 'Menu',
                'menu_desc' => 'Manajemen Menu',
                'menu_url' => 'base/manage/menu',
                'menu_nomer' => 4,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => 'mdi mdi-menu',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ],[
                'portal_id' => 1,
                'parent_id' => 0,
                'menu_title' => 'Portal',
                'menu_desc' => 'Manajemen Portal',
                'menu_url' => 'base/manage/portal',
                'menu_nomer' => 5,
                'active_st' => 'yes',
                'display_st' => 'yes',
                'menu_st' => 'internal',
                'menu_icon' => 'mdi mdi-web',
                'menu_target' => 'self',
                'created_at' =>  Carbon::today(),
                'updated_at' =>  Carbon::today(),
            ],
        ];
        // default portal
        DB::table('menu')->insert($data);
    }
}
