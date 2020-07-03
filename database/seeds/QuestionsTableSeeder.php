<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
	        [
	          'user_id' => 1,
	          'title' => '質問1のタイトル',
	          'body' => '質問1の本文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 2,
	          'title' => '質問2のタイトル',
	          'body' => '質問2の本文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 3,
	          'title' => '質問3のタイトル',
	          'body' => '質問3の本文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 1,
	          'title' => '質問4のタイトル',
	          'body' => '質問4の本文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 2,
	          'title' => '質問5のタイトル',
	          'body' => '質問5の本文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 3,
	          'title' => '質問6のタイトル',
	          'body' => '質問6の本文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
        ]);
    }
}
