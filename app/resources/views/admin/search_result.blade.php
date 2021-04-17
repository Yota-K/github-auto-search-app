@extends ('layouts.app')

@section ('content')
  <h1>検索結果一覧</h1>
  @if ($search_results->count() === 0)
    <p>検索結果がありません</p>
  @else
  <form method="GET" action="{{ route('search_result_csv_download', ['keyword_group_id' => $keyword_group_id]) }}">
    <input
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      type="submit"
      value="ダウンロード"
    >
  </form>
    <table class="w-full table-auto">
      <tr>
        <th class="text-base px-4 py-2">リポジトリ名</th>
        <th class="text-base px-4 py-2">アイコン</th>
        <th class="w-2/5 text-base px-4 py-2">デスクリプション</th>
        <th class="text-base px-4 py-2">総スター数</th>
      </tr>
      <tbody>
        @foreach ($search_results as $search_result)
          <tr>
            <td class="border px-4 py-2">
              <a class="text-blue-600" href="{{ $search_result->repository_url }}">{{ $search_result->repository_name }}</a>
            </td>
            <td class="border px-4 py-2">
              <img class="w-8 h-auto" src="{{ $search_result->avatar_url }}">
            </td>
            <td class="border px-4 py-2">
              {{ $search_result->description }}
            </td>
            <td class="border px-4 py-2">
              {{ $search_result->star_count }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-5 d-flex justify-content-center">
      {{ $search_results->links() }}
    </div>
  @endif
@endsection
