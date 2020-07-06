<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
	        [
	          'name' => '佐藤一郎',
	          'email' => 'test1@gmail.com',
	          'password' => Hash::make('pass1111'),
	          'email_verified_at' => Carbon::now(),
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'name' => '鈴木二郎',
	          'email' => 'test2@gmail.com',
	          'password' => Hash::make('pass2222'),
	          'email_verified_at' => Carbon::now(),
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'name' => '高橋三郎',
	          'email' => 'test3@gmail.com',
	          'password' => Hash::make('pass3333'),
	          'email_verified_at' => Carbon::now(),
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
        ]);
    }
}
