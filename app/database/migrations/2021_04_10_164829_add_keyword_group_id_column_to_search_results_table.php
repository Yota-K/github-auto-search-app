<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeywordGroupIdColumnToSearchResultsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('search_results', function (Blueprint $table) {
      $table->unsignedBigInteger('keyword_group_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('search_results', function (Blueprint $table) {
      $table->dropColumn('keyword_group_id');
    });
  }
}
