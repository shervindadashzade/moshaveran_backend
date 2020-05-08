<?php

use Illuminate\Database\Seeder;
use App\Admin;
class admins_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = 1234;
        Admin::create(array(
            'fname' => 'امیرحسین',
            'lname' => 'داداش زاده',
            'email' => 'shervin.dadashzade7988@gmail.com',
            'password' => Hash::make($password),
        ));
    }
}
