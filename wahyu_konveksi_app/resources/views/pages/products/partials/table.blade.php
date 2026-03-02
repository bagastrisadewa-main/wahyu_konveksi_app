<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Nama Produk</th>
            <th>Gambar</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Status</th>
            <th width="150">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $product->name }}</td>

                <td>
                    @if(!empty($product->images) && is_array($product->images))
                        <img src="{{ asset('storage/'.$product->images[0]) }}"
                            width="60" class="rounded">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                <td>{{ $product->category ? $product->category->name : '-' }}</td>

                {{-- HITUNG HARGA TOTAL --}}
                <td>
                    @php
                        $totalPrice = $product->price;
                        if($product->auto_select_all_custom && $product->options){
                            $extra = 0;
                            foreach($product->options as $opt){
                                foreach($opt->values as $val){
                                    $extra += $val->extra_price ?? 0;
                                }
                            }
                            $totalPrice += $extra;
                        }
                    @endphp
                    Rp {{ number_format($totalPrice) }}
                </td>

                <td>
                    <span class="badge badge-{{ $product->is_active ? 'success':'secondary' }}">
                        {{ $product->is_active ? 'Aktif':'Nonaktif' }}
                    </span>
                </td>

                <td>
                    <a href="{{ route('product.edit',$product->id) }}" class="btn btn-sm btn-warning">
                        Edit
                    </a>
                    <form action="{{ route('product.destroy',$product->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Data kosong</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $products->links() }}
</div>
