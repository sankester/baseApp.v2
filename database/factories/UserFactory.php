<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Model\Base\UserLogin::class, function (Faker $faker) {
    return [
        'username' => 'admin',
        'email' => 'admin@baseapp.com',
        'password' => bcrypt('admin'), // admin
        'status' => 'developer',
        'experied' => Carbon::today()->addDay(1),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\Base\UserData::class, function (Faker $faker){
    return [
        'nama_lengkap' => 'Ach. Vani ardiansyah',
        'tempat_lahir' => 'Banyuwangi',
        'tanggal_lahir' => '10/05/1996',
        'no_telp'   => '082233637307',
        'alamat'    => 'Dusun Jalen RT 03 RW 02 Desa Setail, Kecamatan Genteng, Kabupaten Banyuwangi'
    ];
});