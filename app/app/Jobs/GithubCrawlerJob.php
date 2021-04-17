<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\KeywordGroup;
use App\Services\GithubCrawlerService;
use App\Models\SearchResult;
use Illuminate\Support\Facades\Log;

class GithubCrawlerJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  /**
   * 検索対象のレコードのインスタンス
   *
   * @var \App\Models\KeywordGroup
   */
  protected $check_keyword_group_record;

  /**
   * Create a new job instance.
   *
   * @param 検索対象のレコードのインスタンス $check_keyword_group_record
   */
  public function __construct(KeywordGroup $check_keyword_group_record)
  {
    $this->check_keyword_group_record = $check_keyword_group_record;
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    $check_keyword_group_record = $this->check_keyword_group_record;

    $keyword_group_id = $check_keyword_group_record->id;
    $keyword = $check_keyword_group_record->keyword;
    $search_repository_num = $check_keyword_group_record->search_repository_num;
    $user_id = $check_keyword_group_record->user_id;

    // 検索対象のキーワードが既に登録されてる時は該当レコードを一度削除する
    $first_record = SearchResult::where('keyword_group_id', $keyword_group_id)
      ->where('user_id', $user_id)
      ->exists();

    if ($first_record) {
      $delete_records = SearchResult::where('keyword_group_id', $keyword_group_id)
        ->where('user_id', $user_id);

      foreach ($delete_records->cursor() as $search_result) {
        $search_result->delete();
      }
    }

    // 検索処理実行
    $GithubCrawlerService = new GithubCrawlerService();
    $get_search_results = $GithubCrawlerService->search_results($keyword, $search_repository_num);
    $status_code = $get_search_results['status_code'];
    $search_results = $get_search_results['results'];

    if ($status_code >= 200 && $status_code <= 299) {
      $i = 0;

      if (!$search_results) {
        $this->check_status_failed($check_keyword_group_record);
      }

      foreach ($search_results as $search_result) {
        if ($i >= $search_repository_num) break;

        $SearchResult = new SearchResult();
        $SearchResult->repository_name = $search_result['full_name'];
        $SearchResult->repository_url = $search_result['html_url'];
        $SearchResult->avatar_url = $search_result['owner']['avatar_url'];
        $SearchResult->description = $search_result['description'];
        $SearchResult->star_count = $search_result['stargazers_count'];
        $SearchResult->user_id = $user_id;
        $SearchResult->keyword_group_id = $keyword_group_id;
        $SearchResult->save();

        $i++;
      }

      // チェック終了後にステータス変更
      $check_keyword_group_record->check_status = $check_keyword_group_record::SUCCESS;
      $check_keyword_group_record->save();
    } else {
      Log::error(sprintf("リクエストボディ: %s\nステータスコード: %d", $search_results, $status_code));

      $this->check_status_failed($check_keyword_group_record);
    }
  }

  /**
   * ステータスコード異常・クローリング結果の取得に失敗した時にステータスをFAILEDに変更する
   *
   */
  private function check_status_failed(KeywordGroup $check_keyword_group_record)
  {
    $check_keyword_group_record->check_status = $check_keyword_group_record::FAILED;
    $check_keyword_group_record->save();

    return false;
  }
}
