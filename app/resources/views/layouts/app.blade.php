<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>{{ isset($title) ? $title . ' | ' : '' }}GitHubリポジトリ自動検索アプリ</title>
  </head>
  <body class="antialiased">
    @include ('includes.header')
    <main>
      <div class="container m-auto px-5 py-20">
        @yield ('content')
      </div>
    </main>
    @include ('includes.footer')
  </body>
</html>
