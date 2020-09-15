<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('caption_ua');
            $table->string('caption_en');
            $table->string('intro_en', 400);
            $table->string('intro_ua', 400);
            $table->text('content_ua');
            $table->text('content_en');
            $table->string('page_photo_path')->nullable(); // photo representing the page
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
        Schema::dropIfExists('pages');
    }
}
