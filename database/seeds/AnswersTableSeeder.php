<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert([
	        [
	          'user_id' => 3,
	          'question_id' => 1,
	          'body' => '質問1の回答文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 1,
	          'question_id' => 2,
	          'body' => '質問2の回答文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 2,
	          'question_id' => 3,
	          'body' => '質問3の回答文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 2,
	          'question_id' => 4,
	          'body' => '質問4の回答文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 3,
	          'question_id' => 5,
	          'body' => '質問5の回答文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'user_id' => 1,
	          'question_id' => 6,
	          'body' => '質問6の回答文です。',
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
        ]);
    }
}
