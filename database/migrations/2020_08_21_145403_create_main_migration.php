<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainMigration extends Migration
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
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('birthdate')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_number')->nullable();
            $table->text('fcm_token')->nullable();
            $table->text('reset_token')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('name');
            $table->integer('number')->nullable(true);
            $table->timestamps();
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number')->nullable(true);
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number')->nullable(true);
            $table->unsignedBigInteger('subcategory_id');
            $table->timestamps();

            $table->foreign('subcategory_id')->references('id')->on('subcategories')->cascadeOnDelete();
        });

        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('thumbnail')->nullable(true);
            $table->text('description');
            $table->timestamp('suspended_at')->nullable(true);
            $table->timestamps();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('video_id');
            $table->text('url');
            $table->text('thumbnail');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('channel_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_published');
            $table->boolean('is_published_now');
            $table->boolean('is_upload_shown')->default(true);
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('channels')->cascadeOnDelete();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->nullOnDelete();
        });

        Schema::create('video_labels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('video_id');
            $table->unsignedBigInteger('label_id')->nullable();
            $table->timestamps();

            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
            $table->foreign('label_id')->references('id')->on('labels')->nullOnDelete();
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('channel_id');
            $table->boolean('is_notif_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('channel_id')->references('id')->on('channels');
        });

        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('video_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('video_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
        });

        Schema::create('app_policies', function (Blueprint $table) {
            $table->string("name")->primary();
            $table->text("content");
            $table->timestamps();
        });

        Schema::create('user_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->text('description');
            $table->text('image_url');
            $table->boolean('is_solved')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('user_insights', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->text('detail');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('user_recommendations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string('channel_name');
            $table->text('channel_url');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('blacklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('channel_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('channel_id')->references('id')->on('channels')->cascadeOnDelete();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_super')->default(false);
            $table->timestamps();
        });

        Schema::create('role_admin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('admin_id');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->cascadeOnDelete();
            $table->foreign('admin_id')->references('id')->on('admins')->cascadeOnDelete();
        });

        Schema::create('later_video', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('video_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
        });

        Schema::create('playlist_video', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('playlist_id');
            $table->unsignedBigInteger('video_id');
            $table->timestamps();

            $table->foreign('playlist_id')->references('id')->on('playlists')->cascadeOnDelete();
            $table->foreign('video_id')->references('id')->on('videos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_policies');
        Schema::dropIfExists('video_labels');
        Schema::dropIfExists('video_views');
        Schema::dropIfExists('later_video');
        Schema::dropIfExists('playlist_video');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('followers');
        Schema::dropIfExists('labels');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('playlists');
        Schema::dropIfExists('blacklists');
        Schema::dropIfExists('user_reports');
        Schema::dropIfExists('user_insights');
        Schema::dropIfExists('user_recommendations');
        Schema::dropIfExists('users');
        Schema::dropIfExists('role_admin');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('channels');
    }
}
