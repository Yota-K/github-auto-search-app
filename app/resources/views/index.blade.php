@extends ('layouts.app')

@section ('content')
  @if (!Auth::check())
    <div class="pb-36">
      <div class="flex justify-center">
        <a href="/login" class="bg-red-600 hover:bg-red-500 text-white btn-base-style">ログイン</a>
      </div>
      <h2 class="text-2xl my-2">どんなアプリ？</h2>
      <ul class="list-disc">
        <li>事前に登録したキーワードをもとにGitHub内のリポジトリを自動で検索（GitHub APIを使用する）して、検索結果をDBに保存できる</li>
        <li>指定した時間に検索を行いデータの保存・更新を行うことができる</li>
        <li>検索処理は手動でも実行することもできる</li>
        <li>検索結果は一覧表示することができる</li>
        <li>キーワードごとに絞り込み検索もできる</li>
        <li>検索結果はCSV形式でダウンロードできる</li>
        <li>キーワードのCSV一括登録機能もある</li>
      </ul>
      <h2 class="text-2xl my-2">追加したい機能</h2>
      <ul class="list-disc">
        <li>UIを見やすく・スタイル周りの整理</li>
        <li>Supervisorを導入して、Laravelのキューワーカを永続化させる</li>
        <li>GitHubのリポジトリを検索する処理を指定した時間に自動で実行できるようにする</li>
        <li>検索結果の昇順・降順並び替え</li>
        <li>実行結果を絞り込み検索できるようにする</li>
        <li>定期実行が完了したら、slackに通知を送る</li>
        <li>検索対象のキーワードをCSVインポートできるようにする</li>
        <li>登録されたキーワードの中から、選択したキーワード・数のみをCSVダウンロードできるようにする</li>
      </ul>
    </div>
  @endif
@endsection
