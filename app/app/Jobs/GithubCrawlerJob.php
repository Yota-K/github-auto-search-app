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
   * @return void
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

    // 検索処理実行
    $GithubCrawlerService = new GithubCrawlerService();
    $search_results = $GithubCrawlerService->search_results($keyword, $search_repository_num);

    Log::info($search_results);

    if ($search_results) {
      $i = 0;

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
    } else {
      Log::error('リポジトリの検索結果の取得に失敗しました');

      return;
    }
  }
}
