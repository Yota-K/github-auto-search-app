<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubCrawlerService 
{
  const BASE_URL = 'https://api.github.com/search/repositories';

  /**
   * @param 検索対象のキーワード $search_kewword
   * @param 検索したいリポジトリの数 $search_repository_num
   */ 
  public function __construct(string $search_kewword, int $search_repository_num)
  {
    $this->search_keyword = $search_kewword;
    $this->search_repository_num = $search_repository_num;
    $this->github_token = config('app.github_token');
  }

  /**
   * GitHub API経由で、リポジトリを取得する処理
   */
  public function search_results()
  {
    try {
      $format = null;

      // 1〜30件のリポジトリの情報を取得したいとき
      if ($this->search_repository_num <= 30) {
        $format= self::BASE_URL . "?q=%s+in:name&sort=stars&access_token=%s";
      } else {
        // 1～100件目のリポジトリ情報
        // MEMO: 100件以上のリポジトリを取得するには、ループ内でリクエストを送る必要がありそう
        $format= self::BASE_URL . "?q=%s+in:name&sort=stars&access_token=%s&per_page=100&page=1";
      }

      $endpoint = sprintf($format, $this->search_keyword, $this->github_token);

      $response = Http::get($endpoint);
      $results = $response->json();

      if (!$results) return;

      return $results;
    } catch(Exception $er) {
      throw $er;
    }
  }
}
