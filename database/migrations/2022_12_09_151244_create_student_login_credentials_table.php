<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLoginCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_login_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id');
            $table->string('mobile_no', 255)
                ->nullable();
            $table->string('email')
                ->unique();
            $table->string('username')
                ->unique();
            $table->string('password');
            $table->date('confirmation_date')
                ->nullable();
            $table->string('token', 254)
                ->nullable();
            $table->unsignedInteger('reset_by')
                ->nullable();
            $table->dateTime('reset_password_date')
                ->nullable();
            $table->boolean('is_verified')
                ->default(0);
            $table->unsignedInteger('blocked_by')
                ->nullable();
            $table->dateTime('blocked_date')
                ->nullable();
            $table->string('registration_token', 100);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_login_credentials');
    }
}
