<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="update_password_current_password" class="form-label fw-semibold" style="color:#3d0c07;">Current Password</label>
        <input id="update_password_current_password" type="password" name="current_password"
               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
               autocomplete="current-password">
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password" class="form-label fw-semibold" style="color:#3d0c07;">New Password</label>
        <input id="update_password_password" type="password" name="password"
               class="form-control @error('password', 'updatePassword') is-invalid @enderror"
               autocomplete="new-password">
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="update_password_password_confirmation" class="form-label fw-semibold" style="color:#3d0c07;">Confirm Password</label>
        <input id="update_password_password_confirmation" type="password" name="password_confirmation"
               class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
               autocomplete="new-password">
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-key me-1"></i> Update Password
        </button>
        @if (session('status') === 'password-updated')
            <span class="text-success small"><i class="fas fa-check me-1"></i>Saved!</span>
        @endif
    </div>
</form>
