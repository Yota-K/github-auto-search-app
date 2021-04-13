<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeywordGroup;
use App\Jobs\GithubCrawlerJob;

class ManualCheckController extends Controller
{
  public function manual_check(int $keyword_group_id)
  {
    $KeywordGroup = new KeywordGroup();
    $check_keyword_group_record = $KeywordGroup::where('id', $keyword_group_id)
      ->findOrFail($keyword_group_id);

    // チェックを行うためのフラグをチェック中に変更
    $check_keyword_group_record->check_status = $KeywordGroup::RUNNING;
    $check_keyword_group_record->save();

    // // Githubのクローリングを行うジョブを実行する
    GithubCrawlerJob::dispatch($check_keyword_group_record);

    return redirect('/admin');
  }
}
