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
            $table->string('name');
            $table->string('title');
            $table->string('phone_number');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code');
            $table->longText('about');
            $table->string('profile_photo');
            $table->string('landline')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('google_plus')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tumbler')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
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
