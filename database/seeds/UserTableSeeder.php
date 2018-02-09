<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // default user login
        DB::table('user_login')->insert([
            'username' => 'admin',
            'email' => 'admin@baseapp.com',
            'password' => bcrypt('admin'), // admin
            'status' => 'aktif',
            'experied' => Carbon::today()->addDay(1),
            'remember_token' => str_random(10),
            'created_at' =>  Carbon::today(),
            'updated_at' =>  Carbon::today(),
        ]);
        // default user data
        DB::table('user_data')->insert([
            'user_login_id' => 1,
            'nama_lengkap' => 'Ach. Vani ardiansyah',
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => Carbon::createFromDate('1996','05','10'),
            'jabatan'   => 'developer',
            'no_telp'   => '082233637307',
            'alamat'    => 'Dusun Jalen RT 03 RW 02 Desa Setail, Kecamatan Genteng, Kabupaten Banyuwangi',
            'created_at' =>  Carbon::today(),
            'updated_at' =>  Carbon::today(),
        ]);
    }
}
