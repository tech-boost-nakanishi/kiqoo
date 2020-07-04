<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
	        [
	          'question_user_id' => 1,
	          'answer_id' => 1,
	          'review' => 4,
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'question_user_id' => 1,
	          'answer_id' => 4,
	          'review' => 1,
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'question_user_id' => 2,
	          'answer_id' => 2,
	          'review' => 5,
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'question_user_id' => 2,
	          'answer_id' => 5,
	          'review' => 5,
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'question_user_id' => 3,
	          'answer_id' => 3,
	          'review' => 1,
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
	        [
	          'question_user_id' => 3,
	          'answer_id' => 6,
	          'review' => 1,
	          'created_at' => Carbon::now(),
	          'updated_at' => Carbon::now(),
	        ],
        ]);
    }
}
