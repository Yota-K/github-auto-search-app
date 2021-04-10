<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeywordGroupSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('keyword_groups')->insert([
      [
        'keyword' => 'react',
        'keyword_memo' => 'メモメモ',
        'search_repository_num' => 30,
        'auto_check_date' => now(),
        'user_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
      ],
      [
        'keyword' => 'laravel',
        'keyword_memo' => null,
        'search_repository_num' => 10,
        'auto_check_date' => now(),
        'user_id' => 2,
        'created_at' => now(),
        'updated_at' => now()
      ],
      [
        'keyword' => 'Node',
        'keyword_memo' => 'Node.jsに関するリポジトリ。',
        'search_repository_num' => 50,
        'auto_check_date' => now(),
        'user_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
      ],
      [
        'keyword' => 'Vue',
        'keyword_memo' => null,
        'search_repository_num' => 20,
        'auto_check_date' => now(),
        'user_id' => 3,
        'created_at' => now(),
        'updated_at' => now()
      ],
      [
        'keyword' => 'jamstack',
        'keyword_memo' => null,
        'search_repository_num' => 20,
        'auto_check_date' => now(),
        'user_id' => 1,
        'created_at' => now(),
        'updated_at' => now()
      ],
      [
        'keyword' => 'jamstack',
        'keyword_memo' => null,
        'search_repository_num' => 20,
        'auto_check_date' => now(),
        'user_id' => 2,
        'created_at' => now(),
        'updated_at' => now()
      ]
    ]);
  }
}
