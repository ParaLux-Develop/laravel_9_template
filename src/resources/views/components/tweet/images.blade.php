@props([
  'images' => []
])

@if (count($images) > 0)
  <div>
    <div>
      @foreach ($images as $image)
          <div>
            <div>
              <a @click="$dispatch('img-modal', { imgModalSrc:'{{ asset('storage/images/' . $image->name) }}'})"
                class="cursor-pointer">
              <img class="object-fit w-full" src="{{ asset('storage/images/' . $image->name) }}" alt="{{ $image->name }}">
              </a>
            </div>
          </div>
      @endforeach
    </div>
  </div>
@endif  