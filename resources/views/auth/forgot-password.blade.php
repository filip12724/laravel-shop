<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-key d-block"></i>
            <h4>Forgot Password</h4>
        </div>
        <div class="auth-body">

            <p style="font-size:.875rem; color:#666; margin-bottom:1.25rem;">
                Forgot your password? No problem. Enter your email address and we'll send you a reset link.
            </p>

            @if (session('status'))
                <div style="background:#fdf5f4;border-left:4px solid #C3110C;border-radius:6px;padding:10px 14px;margin-bottom:1rem;font-size:.875rem;color:#740A03;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-check-circle" style="color:#C3110C;"></i>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4">
                    <a href="{{ route('login') }}" class="text-muted-link">
                        <i class="fas fa-arrow-left me-1"></i> Back to login
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-paper-plane me-1"></i> Send Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
