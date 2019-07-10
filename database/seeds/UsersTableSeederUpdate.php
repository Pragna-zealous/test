<?php

use Illuminate\Database\Seeder;

class UsersTableSeederUpdate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@zealousys.com',
            'password' => bcrypt('ze@lous2012'),
            'whatsapp_notification' => 1,
            'email_notification' => 1,
            'user_type' => 'admin',
        ]);
    }
}
