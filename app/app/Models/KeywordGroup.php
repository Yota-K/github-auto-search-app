<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordGroup extends Model
{
  use HasFactory;

  /**
   * 日付を変形する属性
   *
   * @var array
   */
  protected $dates = [
    'auto_check_date',
  ];

  // 
  /**
   * true・falseに変換する型キャスト
   * 
   * @var array
   */
  protected $casts = [
    'check_result' => 'boolean'
  ];

  /**
   * 編集画面に表示する整形済みの日付と時間
   * <input type="datetime-local" >のvalueとして指定する
   * @var string
   */
  public function auto_check_date_formatted()
  {
    $auto_check_date = $this->auto_check_date;

    if ($auto_check_date) {
      $date = $auto_check_date->format('Y-m-dTH:i');
      return preg_replace('/JST/', 'T', $date);
    } else {
      return '';
    }
  }
}
