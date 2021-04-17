<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchResult;
use App\Models\KeywordGroup;
use Illuminate\Support\Facades\Auth;
use App\Services\SearchResultService;

class SearchResultController extends Controller
{
  /**
   * クローリング結果を一覧で表示
   *
   * @param  keyword_groupsテーブルのID
   * @return \Illuminate\Http\Response
   */
  public function show(int $keyword_group_id)
  {
    $user_id = Auth::id();

    $search_results = SearchResult::where('keyword_group_id', $keyword_group_id)
      ->where('user_id', $user_id)
      ->orderBy('star_count', 'desc')
      ->paginate(10);

    return view('admin.search_result', compact('search_results', 'keyword_group_id'));
  }

  /**
   * 検索結果のCSVダウンロード
   *
   * @param  keyword_groupsテーブルのID
   */
  public function csv_download(int $keyword_group_id)
  {
    $user_id = Auth::id();
    $KeywordGroup = KeywordGroup::where('id', $keyword_group_id)->where('user_id', $user_id)->findOrFail($keyword_group_id);
    $search_keyword = $KeywordGroup->keyword;

    // ダウンロードするCSVファイル名を生成
    $SearchResultService = new SearchResultService();
    $download_filename = $SearchResultService->csv_download_filename($search_keyword);

    // 出力対象のデータを取得
    $search_results = $SearchResultService->get_search_results($keyword_group_id, $user_id);

    // CSVエクスポート処理
    return $SearchResultService->export_csv(
      $SearchResultService::CSV_HEADER,
      $download_filename,
      $search_results->cursor()
    );
  }
}
