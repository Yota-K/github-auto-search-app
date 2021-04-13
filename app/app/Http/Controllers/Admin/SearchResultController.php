<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SearchResult;
use Illuminate\Support\Facades\Auth;

class SearchResultController extends Controller
{
  /**
   * クローリング結果を一覧で表示
   *
   * @param  \App\Models\SearchResult  $searchResult
   * @return \Illuminate\Http\Response
   */
  public function show(int $id)
  {
    $user_id = Auth::id();

    $SearchResult = new SearchResult();
    $search_results = $SearchResult::where('keyword_group_id', $id)
      ->where('user_id', $user_id)
      ->orderBy('star_count', 'desc')
      ->paginate(10);

    return view('admin.search_result', compact('search_results'));
  }
}
