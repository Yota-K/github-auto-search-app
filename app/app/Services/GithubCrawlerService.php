<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubCrawlerService {
  const BASE_URL = 'https://api.github.com/search/repositories';

  public function __construct(string $search_kewword)
  {
    $this->search_keyword = $search_kewword;
    $this->github_token = config('app.github_token');
  }

  public function search_results()
  {
    try {
      $format= self::BASE_URL . "?q=%s+in:name&sort=stars&per_page=100&page=1&access_token=%s";
      $endpoint = sprintf($format, $this->search_keyword, $this->github_token);

      $response = Http::get($endpoint);
      $results = $response->json();

      var_dump($results);
    } catch(Exception $er) {
      var_dump($er);
      exit();
    }
  }
}
