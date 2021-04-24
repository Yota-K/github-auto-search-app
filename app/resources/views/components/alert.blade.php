@if (session('flash_message'))
  <div id="alert" class="fixed bottom-2 right-2">
    <div class="text-white px-6 py-4 border-0 rounded relative {{ session('bg_color') }}">
      <span class="inline-block align-middle mr-8">{{ session('flash_message') }}</span>
      <button id="close-btn" class="bg-transparent text-2xl font-semibold leading-none right-0 top-0 mr-6 outline-none focus:outline-none">
        <span>×</span>
      </button>
    </div>
  </div>
@endif
