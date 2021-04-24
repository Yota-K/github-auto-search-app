<header class="top-0 lef-0 w-full z-40 bg-white fixed border-b border-gray-200">
  <div class="container max-w-screen-lg m-auto flex justify-between items-center px-6">
    <a class="navbar-brand text-3xl" href="/">GitHubリポジトリ自動検索アプリ</a>
    <nav class="flex">
      @auth
        <a href="{{ route('admin') }}" class="nav-link">管理画面</a>
        <a href="{{ route('keyword.create') }}" class="nav-link">キーワードの新規登録</a>
        <a href="#" class="nav-link" onClick="(function(){
          document.getElementById('logout-form').submit();
          return false;
          })();">ログアウト</a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
          @csrf 
        </form>
      @endauth
    </nav>
  </div>
</header>
