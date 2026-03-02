<div class="d-flex justify-content-center flex-wrap mb-4">
  <button class="btn btn-outline-primary m-2 active title-btn" data-title="">
    Semua
  </button>
  @foreach($galleries as $gallery)
    <button class="btn btn-outline-primary m-2 title-btn" data-title="{{ $gallery->title }}">
      {{ $gallery->title }}
    </button>
  @endforeach
</div>
