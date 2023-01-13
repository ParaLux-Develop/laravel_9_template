@extends('layouts.app')

@section('content')
<body>
  <h1 class="fs_30">つぶやきアプリ</h1>
@auth
  <div class="form">
    <p class="fs_20">投稿フォーム</p>
    @if (session('feedback.success'))
        <p style="color:green">{{ session('feedback.success') }}</p>
    @endif
    <form action="{{ route('tweet.store') }}" method="post">
      @csrf
      <label for="tweet-content">つぶやき</label>
      <span>140文字まで</span>
      <textarea id="tweet-content" type="text" name="tweet" placeholder="つぶやきを入力"></textarea>
      @error('tweet')
      <p style="color:red;">{{ $message }}</p>
      @enderror
      <button type="submit" name=""submit>投稿</button>
    </form>
  </div>
@endauth
    @foreach ($tweets as $tweet)
      <details>
        <summary>{{ $tweet->content }} by {{ $tweet->user->name }}</summary>
        @if (\Illuminate\Support\Facades\Auth::id() === $tweet->user_id)
        <div>
          <a href="{{ route('tweet.edit', ['tweetId' => $tweet->id]) }}">編集</a>
          <form action="{{ route('tweet.destroy', ['tweetId' => $tweet->id]) }}" method="post">
          @csrf
          <button type="submit">削除</button>
          </form>
        </div>
        @else
        編集できません
        @endif
      </details>
    @endforeach
</body>
</html>

@endsection
{{-- <x-layout title="TOP|つぶやきアプリ">
  <h1>ここに内容が入ります</h1>
</x-layout> --}}