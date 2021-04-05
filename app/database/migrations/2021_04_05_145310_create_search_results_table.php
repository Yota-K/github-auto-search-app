<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchResultsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('search_results', function (Blueprint $table) {
      $table->id();
      $table->string('repository_name');
      $table->string('repository_url');
      $table->string('avatar_url');
      // 余裕を持って500文字くらいにしておく
      $table->string('description', 500)->nullable();
      $table->unsignedBigInteger('star_count');
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
    Schema::dropIfExists('search_results');
  }
}
