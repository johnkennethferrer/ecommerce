<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User([
        	'name' => 'JKF',
        	'email' => 'johnkenneth3010@gmail.com',
        	'contact_no' => '09061033972',
        	'role_id' => 1,
        	'password' => '$2y$10$xlUseV2TF6P7c8snNo91mOBxL8IieqdtJUii4eZYFDpztjUeMr4ke'
        ]);
        $user->save();
    }
}
    