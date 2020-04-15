<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_verify_token')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('qualification')->nullable();
            $table->string('hobby')->nullable();
            $table->string('introduction')->nullable();
            $table->string('image_path')->default("https://kiqooimage.s3.us-east-2.amazonaws.com/BIkd1g42sDeFjUxxXr5ydLfOBSBNMxQffv6xT7xX.jpeg");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
