<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeywordGroup;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * 管理画面
   * 登録されたキーワード一覧を表示
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user_id = Auth::id();

    $keyword_groups = KeywordGroup::where('user_id', $user_id)
      ->orderBy('id', 'desc')
      ->paginate(10);

    return view('admin.index', compact('keyword_groups'));
  }
}
