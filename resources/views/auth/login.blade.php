<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-sign-in-alt d-block"></i>
            <h4>Welcome Back</h4>
        </div>
        <div class="auth-body">

            @if (session('status'))
                <div style="background:#fdf5f4;border-left:4px solid #C3110C;border-radius:6px;padding:10px 14px;margin-bottom:1rem;font-size:.875rem;color:#740A03;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-check-circle" style="color:#C3110C;"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label fw-normal" for="remember_me" style="color:#555;">
                            Remember me
                        </label>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="text-muted-link" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-sign-in-alt me-1"></i> Log in
                    </button>
                </div>

                <hr style="border-color:#e8d5d0; margin: 1.25rem 0 1rem;">
                <p class="text-center mb-0" style="font-size:.875rem; color:#666;">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-muted-link fw-semibold">Register</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
