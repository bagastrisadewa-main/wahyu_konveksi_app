<div class="login-page-wrapper">
    <div class="login-card">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <h4 class="text-center mb-4">Login</h4>

                {{-- Alert sukses atau error --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form Login --}}
                    <form method="POST" action="{{ route('frontend.login.submit') }}">
                        @csrf

                        <!-- Tambahkan ini: input hidden untuk redirect -->
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>


                <div class="mt-3 text-center">
                    <a href="{{ route('frontend.register') }}">Belum punya akun? Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
