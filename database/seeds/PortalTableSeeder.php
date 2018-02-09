<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // default portal
        DB::table('portal')->insert([
            'portal_nm' => 'Base Admin',
            'site_title' => 'Base Manajemen',
            'site_name' => 'Base Manajemen', // admin
            'site_desc' => 'Portal khusus untup developer mengelola aplikasi',
            'site_favicon' => '-',
            'site_logo' => '-',
            'meta_keyword' => '-',
            'meta_desc' => '-',
            'created_at' =>  Carbon::today(),
            'updated_at' =>  Carbon::today(),
        ]);
    }
}
