<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_translation_id');
            $table->integer('parent_id')->nullable();
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('post_translation_id')->references('id')->on('post_translations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_comments', function (Blueprint $table) {
            $table->dropForeign(['post_translation_id']);
        });
        Schema::dropIfExists('post_comments');
    }
}
