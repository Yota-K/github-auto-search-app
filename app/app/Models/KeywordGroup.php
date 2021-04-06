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
}
