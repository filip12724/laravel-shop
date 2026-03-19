<p class="text-muted small mb-3">
    Once your account is deleted, all of its resources and data will be permanently deleted.
    Before deleting your account, please download any data you wish to retain.
</p>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="fas fa-trash-alt me-1"></i> Delete Account
</button>

{{-- Confirmation Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:10px;overflow:hidden;border:none;">
            <div class="modal-header" style="background:#fff5f5;border-bottom:3px solid #dc3545;">
                <h5 class="modal-title fw-bold" id="deleteAccountModalLabel" style="color:#7a1020;">
                    <i class="fas fa-exclamation-triangle me-2" style="color:#dc3545;"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Are you sure you want to delete your account? This action cannot be undone —
                        all data will be permanently removed. Please enter your password to confirm.
                    </p>
                    <div class="mb-3">
                        <label for="delete_password" class="form-label fw-semibold" style="color:#3d0c07;">Password</label>
                        <input id="delete_password" type="password" name="password"
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="Enter your password">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f5ddd9;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Yes, Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        modal.show();
    });
</script>
@endpush
@endif
