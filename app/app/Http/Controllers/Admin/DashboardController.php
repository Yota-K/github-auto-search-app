<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeywordGroup;

class DashboardController extends Controller
{
  /**
   * 管理画面
   * 登録されたキーワド一覧を表示
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $keyword_groups = KeywordGroup::orderBy('id', 'desc')->paginate(10);
    return view('admin.index', compact('keyword_groups'));
  }
}
