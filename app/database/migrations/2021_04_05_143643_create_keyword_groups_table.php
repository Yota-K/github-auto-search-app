<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordGroupsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('keyword_groups', function (Blueprint $table) {
      $table->id();
      $table->char('keyword', 50);
      $table->string('keyword_memo')->nullable();
      $table->unsignedTinyInteger('search_repository_num');
      $table->boolean('check_result')->nullable($value = true);
      $table->timestamp('auto_check_date')->nullable();
      $table->unsignedBigInteger('user_id');
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
    Schema::dropIfExists('keyword_groups');
  }
}
