<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold" style="color:#3d0c07;">Name</label>
        <input id="name" type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold" style="color:#3d0c07;">Email</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-muted small mb-1">Your email address is unverified.</p>
                <button form="send-verification" class="btn btn-sm btn-outline-secondary">
                    Re-send verification email
                </button>
            </div>
            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 small text-success">A new verification link has been sent to your email address.</p>
            @endif
        @endif
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Save Changes
        </button>
        @if (session('status') === 'profile-updated')
            <span class="text-success small"><i class="fas fa-check me-1"></i>Saved!</span>
        @endif
    </div>
</form>
