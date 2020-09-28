<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->enum('order_type', ['date_desc', 'date_asc', 'order_num_desc', 'order_num_asc'])->nullable(); // for the container page
            $table->enum('view_type', ['list', 'tiles'])->nullable(); // for the container page
            $table->integer('order_num')->nullable(); // for the content page
            $table->unsignedBigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('pages'); // for the content page hierarchy

            $table->string('intro_en', 400)->nullable()->change();
            $table->string('intro_ua', 400)->nullable()->change();
            $table->text('content_ua')->nullable()->change();
            $table->text('content_en')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('order_type');
            $table->dropColumn('view_type');
            $table->dropColumn('order_num');
            $table->dropColumn('parent_code');

            $table->string('intro_en', 400)->change();
            $table->string('intro_ua', 400)->change();
            $table->text('content_ua')->change();
            $table->text('content_en')->change();
        });
    }
}
