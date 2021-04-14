<?php

namespace App\Services;

class GithubCrawlerService 
{
  const BASE_URL = 'https://api.github.com/search/repositories';

  public function __construct()
  {
    $this->github_token = config('app.github_token');
  }

  /**
   * GitHub API経由で、リポジトリを取得する処理
   *
   * @param 検索対象のキーワード $keyword
   * @param 検索したいリポジトリの数 $search_repository_num
   */
  public function search_results(string $keyword, int $search_repository_num)
  {
    $format = null;

    // 1〜30件のリポジトリの情報を取得したいとき
    if ($search_repository_num <= 30) {
      $format = self::BASE_URL . "?q=%s+in:name&sort=stars&access_token=%s";
    } else {
      // 1～100件目のリポジトリ情報
      // MEMO: 100件以上のリポジトリを取得するには、ループ内でリクエストを送る必要がありそう
      $format = self::BASE_URL . "?q=%s+in:name&sort=stars&access_token=%s&per_page=100&page=1";
    }

    $endpoint = sprintf($format, $keyword, $this->github_token);

    $client = new \GuzzleHttp\Client();
    $response = $client->request('GET', $endpoint);
    $body = $response->getBody();
    $status_code = $response->getStatusCode();

    $results = json_decode($body, true);

    return [
      'status_code' => $status_code,
      'results' => $results['items'],
    ];
  }
}
