@extends ('layouts.app')

@section ('content')
  <h1>管理画面</h1>
  @if (!$keyword_groups)
    <p>キーワードが登録されていません</p>
  @else
    <table class="w-full table-auto">
      <tr>
        <th class="text-base px-4 py-2">キーワード</th>
        <th class="text-base px-4 py-2">検索を行うリポジトリ数</th>
        <th class="text-base px-4 py-2">自動チェック</th>
        <th class="text-base px-4 py-2">チェック日時</th>
        <th class="text-base px-4 py-2">検索状況</th>
        <th class="text-base px-4 py-2">検索結果</th>
        <th class="text-base px-4 py-2">手動チェック</th>
      </tr>
      <tbody>
        @foreach ($keyword_groups as $keyword_group)
        <tr>
          <td class="border px-4 py-2">
            <a class="underline" href="{{ route('keyword.edit', ['keyword' => $keyword_group->id]) }}">{{ $keyword_group->keyword }}</a>
          </td>
          <td class="border px-4 py-2">
            {{ $keyword_group->search_repository_num }}
          </td>
          <td class="border px-4 py-2">
            @if (is_null($keyword_group->auto_check_date))
              <span>-</span>
            @else
              <span>{{ $keyword_group->auto_check_date->format('Y/m/d H:i') }}</span>
            @endif
          </td>
          <td class="border px-4 py-2">
            @if (is_null($keyword_group->updated_at))
              <span>-</span>
            @else
              <span>{{ $keyword_group->updated_at->format('Y/m/d H:i') }}</span>
            @endif
          </td>
          <td class="border px-4 py-2">
            @if (is_null($keyword_group->check_status))
              <span>-</span>
            @elseif ($keyword_group->check_status === 0)
              <span class="font-semibold text-blue-600">処理中</span>
            @elseif ($keyword_group->check_status === 1)
              <span class="font-semibold text-green-600">成功</span>
            @else
              <span class="font-semibold text-red-600">失敗</span>
            @endif
          </td>
          <td class="border px-4 py-2">
            <a class="text-blue-600 underline" href="{{ route('search_result', ['keyword_group_id' => $keyword_group->id]) }}">検索結果</a>
          </td>
          <td class="border px-4 py-2">
            <form method="POST" action="{{ route('manual_check', ['keyword_group_id' => $keyword_group->id]) }}">
              @csrf
              <button class="font-semibold text-red-600" type="submit">手動チェック</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-5 d-flex justify-content-center">
      {{ $keyword_groups->links() }}
    </div>
  @endif
@endsection
