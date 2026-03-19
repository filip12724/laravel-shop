<x-guest-layout>
    <div class="auth-card">
        <div class="auth-header">
            <i class="fas fa-user-plus d-block"></i>
            <h4>Create Account</h4>
        </div>
        <div class="auth-body">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </button>
                </div>

                <hr style="border-color:#e8d5d0; margin: 1.25rem 0 1rem;">
                <p class="text-center mb-0" style="font-size:.875rem; color:#666;">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-muted-link fw-semibold">Log in</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
