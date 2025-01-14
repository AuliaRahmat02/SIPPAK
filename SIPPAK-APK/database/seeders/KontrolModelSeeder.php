<?php

namespace Database\Seeders;

use App\Models\kontrolModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KontrolModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('kontrol')->insert([
            [
                "set"=>'REG',
                "code"=>'539',
            ],[
                "set"=>'FRG',
                "code"=>'935',
            ]
            
            
        ]);
    }
}
