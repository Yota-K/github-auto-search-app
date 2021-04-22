<?php

namespace App\Services;

use GuzzleHttp\Promise;

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
   * @return array|false
   */
  public function search_results(string $keyword, int $search_repository_num)
  {
    $promises = $endpoints = $results= [];

    $format = self::BASE_URL . '?q=%s+in:name&sort=stars&access_token=%s&per_page=100&page=%d';
    $client = new \GuzzleHttp\Client();

    $search_count= 1;

    // 検索を行うエンドポイントに対して非同期でリクエストを送る
    while ($search_count <= ceil($search_repository_num / 100)) {
      $endpoint = sprintf($format, $keyword, $this->github_token, $search_count);
      $endpoints[] = $endpoint;
      $promises[] = $client->getAsync($endpoint);

      $search_count++;
    }

    if (!$promises) return false;

    // 検索結果を取得する
    // 全てのPromiseが実行された後の結果が配列で返ってくる
    // waitをつけることで、可能であればPromiseが実行されるまで待つ
    foreach (Promise\Utils::all($promises)->wait() as $key => $response) {
      $status_code = $response->getStatusCode();

      if ($status_code >= 200 && $status_code <= 299) {
        $obj = json_decode($response->getBody(), true);
        $results[] = $obj['items'];
      } else {
        Log::error(sprintf('HTTP STATUS CODE %s = %s', $endpoints[$key], $status_code));

        break;
      }
    }

    return $results;
  }
}
