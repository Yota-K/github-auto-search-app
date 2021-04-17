<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\SearchResult;

class SearchResultService
{
  const CSV_HEADER = [
    'キーワード',
    'リポジトリ名',
    'URL',
    'デスクリプション',
    '総スター数',
    'チェック日',
  ];

  /**
   * CSVファイルの名前を出力
   */
  public function csv_download_filename(string $search_keyword)
  {
    $now = Carbon::now();
    return sprintf('%sのクローリング結果_%s.csv', $search_keyword, $now->format('Y-m-d-h-i'));
  }

  /**
   * CSVファイルに書き出すデータを取得
   *
   */
  public function get_search_results(int $id, int $user_id)
  {
    $query = SearchResult::where('search_results.keyword_group_id', $id)
      ->where('search_results.user_id', $user_id)
      ->join('keyword_groups', 'search_results.keyword_group_id', '=', 'keyword_groups.id')
      ->select(
        'keyword_groups.keyword',
        'search_results.repository_name',
        'search_results.repository_url',
        'search_results.description',
        'search_results.star_count',
        'search_results.created_at'
      )
      ->orderBy('search_results.star_count', 'desc');

    return $query;
  }

  /**
   * 検索結果のCSVエクスポート
   *
   * @param  keyword_groupsテーブルのID
   */
  public function export_csv(array $header, string $download_filename, $cursor)
  {
    return response()->streamDownload(function() use($header, $cursor) {
      // ファイルを書き込みモードで開く
      // w・・・書き込み（ない場合はファイルを新規作成）
      // b・・・バイナリファイルを扱うための指定（無条件で指定推奨）
      $file = fopen('php://output', 'wb');

      if (!$file) return;

      // BOM付きUTF-8にしてExcelで開いても文字化けしないようにする
      fwrite($file, "\xEF\xBB\xBF");

      // ヘッダ行を出力
      fputcsv($file, $header);

      // 検索結果をCSVに書き込む
      foreach ($cursor as $result) {
        fputcsv($file, [
          $result->keyword,
          $result->repository_name,
          $result->repository_url,
          $result->description,
          $result->star_count,
          $result->created_at->format('Y-m-d-h-i'),
        ]);
      }

      fclose($file);
    }, $download_filename);
  }
}
