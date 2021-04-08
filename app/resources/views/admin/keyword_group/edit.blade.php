<?php $title = 'キーワード編集画面' ?>
@extends ('layouts.app')

@section ('content')
  <h1 class="text-2xl">{{ $title }}</h1>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li class="text-red-500">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('keyword.update', ['keyword' => $keyword_group->id]) }}">
    @csrf
    @method ('PATCH')
    <div class="mt-2 mb-4">
      <label class="form-heading" for="keyword">キーワード</label>
      <input
        id="keyword"
        class="w-full form-input block p-2 border border-gray-300 rounded-md"
        type="text"
        value="{{ $keyword_group->keyword }}"
        name="keyword"
        placeholder="リポジトリの検索を行うキーワードを入力してください"
      >
    </div>
    <div class="mt-2 mb-4">
      <label class="form-heading" for="search_repository_num">リポジトリの検索数</label>
      <input
        id="search_repository_num"
        class="w-full form-input block p-2 border border-gray-300 rounded-md"
        type="number"
        value="{{ $keyword_group->search_repository_num }}"
        name="search_repository_num"
      >
    </div>
    <div class="mt-2 mb-4">
      <label class="form-heading" for="auto_check_date">リポジトリの自動クローリング</label>
      <input
        id="auto_check_date"
        class="w-full form-input block p-2 border border-gray-300 rounded-md"
        type="datetime-local"
        value="{{ $keyword_group->auto_check_date_formatted() }}"
        name="auto_check_date"
      />
    </div>
    <div class="mt-2 mb-4">
      <label class="form-heading" for="keyword_memo">メモ</label>
      <textarea
        id="keyword_memo"
        class="w-full px-3 py-2 placeholder-gray-400 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500"
        rows="5"
        name="keyword_memo"
        placeholder="メモを入力してください"
        >{{ $keyword_group->keyword_memo }}</textarea>
    </div>
    <input
      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
      type="submit"
      value="登録"
    >
  </form>
@endsection
