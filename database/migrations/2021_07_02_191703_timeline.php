<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Timeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('timelines');

        Schema::create('timelines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('task_id')->nullable();
            $table->string('user_id');
            $table->json('task_updates');
            $table->integer('progress')->default(0);
            $table->string('notes')->default("No Notes");
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
        //
        Schema::dropIfExists('timelines');

    }
}
