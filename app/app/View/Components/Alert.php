<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
  /**
   * コンポーネントインスタンスを作成
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * コンポーネントを表すビュー／コンテンツを取得
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.alert');
  }
}
