<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeywordGroup;
use Illuminate\Http\Request;
use App\Http\Requests\KeywordGroupRequest;
use Illuminate\Support\Facades\Auth;

class KeywordGroupController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('admin.keyword_group.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
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
    $auto_check_date = $request->auto_check_date;

    if ($auto_check_date || $keyword_memo) {
      $KeywordGroup->auto_check_date = $auto_check_date;
      $KeywordGroup->keyword_memo = $keyword_memo;
    }

    $KeywordGroup->save();

    return redirect('/admin');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\KeywordGroup  $keywordGroup
   * @return \Illuminate\Http\Response
   */
  public function show(KeywordGroup $keywordGroup)
  {
      //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\KeywordGroup  $keywordGroup
   * @return \Illuminate\Http\Response
   */
  public function edit(KeywordGroup $keywordGroup)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\KeywordGroup  $keywordGroup
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, KeywordGroup $keywordGroup)
  {
      //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\KeywordGroup  $keywordGroup
   * @return \Illuminate\Http\Response
   */
  public function destroy(KeywordGroup $keywordGroup)
  {
      //
  }
}
