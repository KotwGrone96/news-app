<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('summary')->nullable();
            $table->text('body')->nullable();
            $table->string('image')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->string('state');
            $table->bigInteger('owner_id');
            $table->string('labels')->nullable();
            $table->string('is_visible', 5);
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
        Schema::dropIfExists('posts');
    }
}
