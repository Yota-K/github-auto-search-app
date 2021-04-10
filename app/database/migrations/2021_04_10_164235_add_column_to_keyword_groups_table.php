<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToKeywordGroupsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('keyword_groups', function (Blueprint $table) {
      $table->unsignedTinyInteger('check_status')->nullable($value = true);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('keyword_groups', function (Blueprint $table) {
      $table->dropColumn('check_status');
    });
  }
}
