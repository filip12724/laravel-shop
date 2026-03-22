<p class="text-muted small mb-3">
    Once your account is deleted, all of its resources and data will be permanently deleted.
    Before deleting your account, please download any data you wish to retain.
</p>

<button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="fas fa-trash-alt me-1"></i> Delete Account
</button>

{{-- Confirmation Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:10px; overflow:hidden; box-shadow:0 8px 32px rgba(40,9,5,.18);">
            <div class="modal-header" style="background:linear-gradient(135deg,#280905,#740A03); border:none; padding:16px 22px;">
                <h5 class="modal-title" id="deleteAccountModalLabel" style="color:#fff; font-weight:700; font-size:1rem; display:flex; align-items:center; gap:10px;">
                    <i class="fas fa-exclamation-triangle" style="color:#E6501B;"></i> Delete Account
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body" style="padding:24px 22px; color:#280905;">
                    @error('active_orders', 'userDeletion')
                    <div style="display:flex; align-items:flex-start; gap:10px; background:#fde8df; border-left:3px solid #C3110C; border-radius:0 6px 6px 0; padding:12px 14px; margin-bottom:16px;">
                        <i class="fas fa-box" style="color:#C3110C; margin-top:2px; flex-shrink:0;"></i>
                        <span style="font-size:.875rem; color:#280905; font-weight:500;">{{ $message }}</span>
                    </div>
                    @else
                    <p style="font-size:.9rem; color:#555; margin-bottom:16px;">
                        Are you sure you want to delete your account? This action <strong style="color:#C3110C;">cannot be undone</strong> —
                        all data will be permanently removed. Please enter your password to confirm.
                    </p>
                    @enderror
                    @if(!$errors->userDeletion->has('active_orders'))
                    <div class="mb-1">
                        <label for="delete_password" class="form-label" style="font-weight:600; font-size:.85rem; color:#740A03;">Password</label>
                        <input id="delete_password" type="password" name="password"
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               style="border-color:#C3110C; border-radius:6px;"
                               placeholder="Enter your password">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                </div>
                <div class="modal-footer" style="border-top:1px solid #f0e8e7; padding:14px 22px; gap:8px;">
                    <button type="button" data-bs-dismiss="modal"
                        style="border:1.5px solid #740A03; color:#740A03; background:transparent; border-radius:4px; font-weight:600; font-size:.875rem; padding:6px 18px; cursor:pointer; transition:all .2s;"
                        onmouseover="this.style.background='#740A03';this.style.color='#fff';"
                        onmouseout="this.style.background='transparent';this.style.color='#740A03';">
                        Cancel
                    </button>
                    @if(!$errors->userDeletion->has('active_orders'))
                    <button type="submit"
                        style="border:none; background:#C3110C; color:#fff; border-radius:4px; font-weight:700; font-size:.875rem; padding:6px 18px; cursor:pointer; transition:background .2s;"
                        onmouseover="this.style.background='#740A03';"
                        onmouseout="this.style.background='#C3110C';">
                        <i class="fas fa-trash-alt me-1"></i> Yes, Delete My Account
                    </button>
                    @endif
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
