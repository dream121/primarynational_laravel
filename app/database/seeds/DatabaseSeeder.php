<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
        $this->call('UserTableSeeder');
	}

}


class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'email' => 'russell@nextgen-soft.com',
            'first_name'=>'Shahjahan',
            'last_name'=>'Russell',
            'username'=>'russell',
            'password'=>Hash::make('123456'),
            'remember_token' => '123',
            'role_id'=>1
        ));
    }

}