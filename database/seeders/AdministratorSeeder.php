<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrator;
use Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create the first ever administrator
        Administrator::create([
            'fldAdministratorEmail' => 'lesterfonggi@gmail.com',
            'fldAdministratorPassword' => Hash::make('Test_123'),
            'fldAdministratorActive' => 1,
            'fldAdministratorFirstname' => 'Lester',
            'fldAdministratorLastname' => 'Doe',
            'fldAdministratorMobile' => '09123456789',
        ]);
    }
}
