<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('email')->unique();
            $table->string('fullname');
            $table->enum('gender', ['L', 'P'])->nullable(true);
            $table->string('birthdate')->nullable(true);
            $table->timestamp('email_verified_at')->nullable();
            /*
            $table->text('verification_number')->nullable(true);
            $table->text('reset_token')
                ->nullable()
                ->default(null);
            $table->text('fcm_token')
		->nullable()
                ->default(null);
            $table->timestamp('suspended_at')->nullable();*/
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
        Schema::dropIfExists('users');
    }
}
