<div class="row g-4">
  @foreach($articles as $article)
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        @if($article->images->first())
          <img src="{{ asset('storage/' . $article->images->first()->image_path) }}" 
               class="card-img-top" alt="{{ $article->title }}">
        @endif
        <div class="card-body">
          <h5 class="card-title">
            <a href="{{ route('frontend.detail_artikel.show', $article->slug) }}" class="text-dark">
              {{ $article->title }}
            </a>
          </h5>
          <p class="card-text text-muted small">
            {{ Str::limit(strip_tags($article->content), 100) }}
          </p>
        </div>
        <div class="card-footer bg-white border-0">
         <a href="{{ route('frontend.detail_artikel.show', $article->slug) }}" class="btn btn-outline-primary btn-sm">
            Baca Selengkapnya
          </a>
        </div>
      </div>
    </div>
  @endforeach
</div>
