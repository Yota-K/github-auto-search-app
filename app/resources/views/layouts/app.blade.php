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
      <div class="container max-w-5xl m-auto pt-36 md:pt-16 px-2">
        @yield ('content')
      </div>
    </main>
    @include ('includes.footer')
  </body>

  @if (Request::is('admin') || Request::is('admin/keyword/*/edit'))
  <script>
    const closeBtn = document.getElementById('close-btn');
    const alertDiv = document.getElementById('alert');

    closeBtn.addEventListener('click', () => {
      alertDiv.style.display = 'none';
    });
  </script>
  @endif
</html>
