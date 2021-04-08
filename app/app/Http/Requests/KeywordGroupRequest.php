<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeywordGroupRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * バリデーションする前に実行される
   * リクエストデータを加工することができる
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    $auto_check_date = $this->input('auto_check_date');

    if ($auto_check_date) {
      $date = strtotime($auto_check_date);
      $formatted_date = date('Y-m-d H:i:s', $date);

      $this->merge([
        'auto_check_date' => $formatted_date, 
      ]);
    }
  }

  /**
   * バリデーション
   *
   * @return array
   */
  public function rules()
  {
    return [
      'keyword' => 'required|max:50',
      'search_repository_num' => 'required|integer|between:1,100',
      'auto_check_date' => 'nullable|date_format:Y-m-d H:i:s',
      'keyword_memo' => 'nullable|min:1'
    ];
  }

  /**
   * バリデーションエラーのカスタム属性の取得
   *
   * @return array
   */
  public function attributes()
  {
    return [
      'keyword' => 'キーワード',
      'search_repository_num' => 'リポジトリの検索数',
      'auto_check_date' => 'チェックを行う日付',
      'keyword_memo' => 'キーワードのメモ'
    ];
  }
}
