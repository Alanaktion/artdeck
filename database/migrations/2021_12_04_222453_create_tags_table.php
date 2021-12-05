<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
        });
        Schema::create('tag_work', function (Blueprint $table) {
            $table->foreignId('work_id')->constrained();
            $table->foreignId('tag_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->unique(['work_id', 'tag_id']);
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
        Schema::dropIfExists('tag_work');
        Schema::dropIfExists('tags');
    }
}
