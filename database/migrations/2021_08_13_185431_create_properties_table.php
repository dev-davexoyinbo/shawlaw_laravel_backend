<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->string("title");
            $table->string("status");
            $table->string("type");
            $table->string("price");
            $table->string("area");
            $table->string("bedroom_count");
            $table->string("bathroom_count");
            $table->json("gallery");
            $table->text("address");
            $table->string("city");
            $table->string("state");
            $table->string("country");
            $table->string("zip_code");
            $table->longText("description");
            $table->string("building_age")->nullable();
            $table->integer("garage_count")->nullable();
            $table->integer("room_count")->nullable();
            $table->json("other_features")->nullable();
            $table->string("contact_name");
            $table->string("contact_email");
            $table->string("contact_phone");
            $table->boolean("is_featured");
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
        Schema::dropIfExists('properties');
    }
}
