@props([
  'tweet' => []
])
<div>
  <ul>
    @foreach ($tweets as $tweet)
        <li>
          <div>
            <span>
              {{ $tweet->user->name }}
            </span>
            <p>{!! nl2br(e($tweet->content)) !!}</p>
            <x-tweet.images :images="$tweet->images"/>
          </div>
        </li>
    @endforeach
  </ul>
</div>