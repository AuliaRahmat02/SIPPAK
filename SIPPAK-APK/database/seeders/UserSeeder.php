<?php

namespace Database\Seeders;

use App\Models\users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    // untuk menambah data kedalam tabel users
    {
        // Admin
        users::create([
            'NIP_User' => 'OPERATOR',
            'Nama_User' => 'OPERATOR',
            'Password' => Hash::make('Diskominfo@2024'),
            'email' => 'CONTOH@gmail.com', //GANTI SESUAI GMAIL BIRO ADMINISTRASI PIMPINAN
            'Biro' => 0,
        ]);



        // // operator
        // users::create([
        //     'NIP_User' => 'operat',
        //     'Nama_User' => 'operat',
        //     'Password' => Hash::make('123'),
        //     'email' => 'farhan2 @gmail.com',
        //     'Biro' => 3,
        //     'opadpim'=>true
        // ]);


        // // jft
        // users::create([
        //     'NIP_User' => 'jft',
        //     'Nama_User' => 'Farhan',
        //     'Password' => Hash::make('123'),
        //     'email' => 'glifordosade@gmail.com',
        //     'Biro' => 3,
        //     "jft" => true
        // ]);

        // // kabag
        // users::create([
        //     'NIP_User' => 'kabag',
        //     'Nama_User' => 'syauqi',
        //     'Password' => Hash::make('123'),
        //     'email' => 'syauqi@gmail.com',
        //     'Biro' => 3,
        //     'kabag'=> true
        // ]);

        // // kabiro
        // users::create([
        //     'NIP_User' => 'kabiro',
        //     'Nama_User' => 'khoiri',
        //     'Password' => Hash::make('123'),
        //     'email' => 'khoiri@gmail.com',
        //     'Biro' => 3,
        //     'kabiro'=> true
        // ]);


        // // =======================================================================================================================
        // // operator per Biro
        // users::create([
        //     'NIP_User' => 'opAdpim',
        //     'Nama_User' => 'Farhan',
        //     'Password' => Hash::make('123'),
        //     'email' => 'farhan1@gmail.com',
        //     'Biro' => 3,
        // ]);

        // users::create([
        //     'NIP_User' => 'opotonom',
        //     'Nama_User' => 'andika',
        //     'Password' => Hash::make('123'),
        //     'email' => 'andika@gmail.com',
        //     'Biro' => 1,
        // ]);

        // users::create([
        //     'NIP_User' => 'ophukum',
        //     'Nama_User' => 'surya',
        //     'Password' => Hash::make('123'),
        //     'email' => 'surya@gmail.com',
        //     'Biro' => 2,
        // ]);

        // users::create([
        //     'NIP_User' => 'opkesra',
        //     'Nama_User' => 'hanafi',
        //     'Password' => Hash::make('123'),
        //     'email' => 'hanafi@gmail.com',
        //     'Biro' => 4,
        // ]);

        // users::create([
        //     'NIP_User' => 'opekonomi',
        //     'Nama_User' => 'zihana',
        //     'Password' => Hash::make('123'),
        //     'email' => 'zihana@gmail.com',
        //     'Biro' => 5,
        // ]);
        // users::create([
        //     'NIP_User' => 'opadpem',
        //     'Nama_User' => 'sulifan',
        //     'Password' => Hash::make('123'),
        //     'email' => 'sulifan@gmail.com',
        //     'Biro' => 6,
        // ]);

        // users::create([
        //     'NIP_User' => 'oporganisasi',
        //     'Nama_User' => 'supriadi',
        //     'Password' => Hash::make('123'),
        //     'email' => 'supriadi@gmail.com',
        //     'Biro' => 7,
        // ]);

        // users::create([
        //     'NIP_User' => 'opumum',
        //     'Nama_User' => 'M. Yani',
        //     'Password' => Hash::make('123'),
        //     'email' => 'myani@gmail.com',
        //     'Biro' => 8,
        // ]);

        // users::create([
        //     'NIP_User' => 'oppbj',
        //     'Nama_User' => 'M. Hatta',
        //     'Password' => Hash::make('123'),
        //     'email' => 'mhatta@gmail.com',
        //     'Biro' => 9,
        // ]);
    }

}
