<div class="list-group">
  @foreach($articles as $article)
    <div class="list-group-item py-4">
      <div class="row g-3 align-items-center">
        <div class="col-md-4">
          @if($article->images->first())
            <img src="{{ asset('storage/' . $article->images->first()->image_path) }}" 
                 class="img-fluid rounded" alt="{{ $article->title }}">
          @endif
        </div>
        <div class="col-md-8">
          <h4>
            <a href="{{ route('frontend.artikel.detail', $article->slug) }}" class="text-dark">
              {{ $article->title }}
            </a>
          </h4>
          <p class="text-muted small mb-2">{{ $article->created_at->format('d M Y') }}</p>
          <p class="text-muted">{{ Str::limit(strip_tags($article->content), 150) }}</p>
          <a href="{{ route('frontend.artikel.detail', $article->slug) }}" class="btn btn-link p-0">
            Baca Selengkapnya →
          </a>
        </div>
      </div>
    </div>
  @endforeach
</div>
