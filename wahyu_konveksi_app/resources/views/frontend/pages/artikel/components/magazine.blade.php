<div class="row g-4">
  @foreach($articles as $key => $article)
    <div class="col-md-{{ $loop->first ? '12' : '6' }}">
      <div class="card h-100 shadow-sm border-0">
        @if($article->images->first())
          <img src="{{ asset('storage/' . $article->images->first()->image_path) }}" 
               class="card-img-top" alt="{{ $article->title }}">
        @endif
        <div class="card-body">
          <h3 class="{{ $loop->first ? 'fw-bold' : '' }}">
            <a href="{{ route('frontend.artikel.detail', $article->slug) }}" class="text-dark">
              {{ $article->title }}
            </a>
          </h3>
          <p class="text-muted small">{{ $article->created_at->format('d M Y') }}</p>
          <p>{{ Str::limit(strip_tags($article->content), $loop->first ? 200 : 100) }}</p>
        </div>
      </div>
    </div>
  @endforeach
</div>
