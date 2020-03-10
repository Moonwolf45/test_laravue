<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSectionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up () {
        Schema::create('user_section', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('sections_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sections_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down () {
        Schema::table('user_section', function (Blueprint $table) {
            $table->dropForeign(['user_section']);
        });

        Schema::dropIfExists('user_section');
    }
}
