<header class="top-0 lef-0 w-full z-40 bg-white fixed border-b border-gray-200">
  <div class="container px-6 mx-auto flex justify-between items-center">
    <a class="navbar-brand text-3xl" href="#">GitHubリポジトリ自動検索アプリ</a>
    <nav>
      @guest
      <a href="/login">ログイン</a>
      @endguest

      @auth
      <a href="#" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-blue-600" onClick="(function(){
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
