<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeywordGroup;
use App\Models\SearchResult;
use App\Http\Requests\KeywordGroupRequest;
use Illuminate\Support\Facades\Auth;

class KeywordGroupController extends Controller
{
  /**
   * データの新規作成
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.keyword_group.create');
  }

  /**
   * データの保存処理
   *
   * @param  \App\Http\Requests\KeywordGroupRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(KeywordGroupRequest $request)
  {
    $user_id = Auth::id();

    $KeywordGroup = new KeywordGroup();
    $KeywordGroup->keyword = $request->keyword;
    $KeywordGroup->search_repository_num = $request->search_repository_num;
    $KeywordGroup->user_id = $user_id;

    // データが入力されている時のみ登録処理を行う
    $keyword_memo = $request->keyword_memo;

    if ($keyword_memo) {
      $KeywordGroup->keyword_memo = $keyword_memo;
    }

    $KeywordGroup->save();

    return redirect('/admin')
      ->with([
        'flash_message' => 'データを保存しました',
        'bg_color' => 'bg-green-500'
      ]);
  }

  /**
   * データの編集画面
   *
   * @param  \App\Models\KeywordGroup  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(int $id)
  {
    $keyword_group = KeywordGroup::findOrFail($id);
    return view('admin.keyword_group.edit', compact('keyword_group'));
  }

  /**
   * データの更新処理
   *
   * @param  \App\Http\Requests\KeywordGroupRequest  $request
   * @param  \App\Models\KeywordGroup  $id
   * @return \Illuminate\Http\Response
   */
  public function update(KeywordGroupRequest $request, int $id)
  {
    $KeywordGroup = KeywordGroup::where('id', $id)->findOrFail($id);

    // ログインしてるユーザーIDと更新しようとしているユーザーのIDが同じかどうかチェック
    if (Auth::id() !== $KeywordGroup->user_id) return;

    $KeywordGroup->keyword = $request->keyword;
    $KeywordGroup->search_repository_num = $request->search_repository_num;

    $keyword_memo = $request->keyword_memo;

    if ($keyword_memo) {
      $KeywordGroup->keyword_memo = $keyword_memo;
    }

    $KeywordGroup->save();

    return redirect()
      ->route('keyword.edit', $KeywordGroup)
      ->with([
        'flash_message' => 'データを更新しました',
        'bg_color' => 'bg-green-500'
      ]);
  }

  /**
   * 削除処理
   *
   * @param  \App\Models\KeywordGroup  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(int $id)
  {
    $KeywordGroup = KeywordGroup::where('id', $id)->findOrFail($id);

    if (Auth::id() !== $KeywordGroup->user_id) return;

    $KeywordGroup->delete();

    // 検索結果がある場合は、検索結果も一緒に削除する
    $search_result_records = SearchResult::where('keyword_group_id', $id);

    if ($search_result_records->exists()) {
      $search_result_records->delete();
    }

    return redirect('/admin')
      ->with([
        'flash_message' => 'データを削除しました',
        'bg_color' => 'bg-red-500'
      ]);
  }
}
