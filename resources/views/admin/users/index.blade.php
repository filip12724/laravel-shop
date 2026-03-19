@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-users mr-2" style="color:#4f46e5;"></i>Users</h3>
    </div>
    <div class="card-body">
        <div class="admin-filter-bar" style="padding:16px 18px;">
            <form method="GET" style="display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;width:100%;">
                <div>
                    <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                        <i class="fas fa-search mr-1" style="color:#4f46e5;"></i>Search
                    </label>
                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name or email…"
                           style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;width:240px;"
                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                           onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                </div>
                <div style="display:flex;gap:8px;align-self:flex-end;">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-search mr-1"></i> Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr data-user="{{ $user->id }}">
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:32px;height:32px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#fff;flex-shrink:0;">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td style="color:#64748b;">{{ $user->email }}</td>
                    <td>
                        @if($user->isAdmin())
                            <span class="role-badge" style="background:#fef2f2;color:#b91c1c;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                                <span style="width:6px;height:6px;background:#ef4444;border-radius:50%;"></span>Admin
                            </span>
                        @else
                            <span class="role-badge" style="background:#f1f5f9;color:#475569;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;">
                                <span style="width:6px;height:6px;background:#94a3b8;border-radius:50%;"></span>User
                            </span>
                        @endif
                    </td>
                    <td style="color:#94a3b8;font-size:.82rem;">{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                        <button class="btn btn-xs btn-warning mr-1 btn-toggle-role"
                                data-url="{{ route('admin.users.toggle-role', $user) }}"
                                title="Toggle role">
                            <i class="fas fa-user-cog"></i>
                        </button>
                        <button class="btn btn-xs btn-danger btn-delete-user"
                                data-url="{{ route('admin.users.destroy', $user) }}"
                                data-name="{{ $user->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        @else
                        <span style="font-size:.75rem;color:#94a3b8;">You</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center" style="padding:32px;color:#94a3b8;">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $users->links('vendor.pagination.bootstrap-4') }}</div>
</div>

{{-- Delete confirmation modal --}}
<div id="deleteUserModal" style="
    display:none;position:fixed;inset:0;z-index:9999;
    background:rgba(15,23,42,.45);backdrop-filter:blur(3px);
    align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:400px;
                box-shadow:0 24px 60px rgba(0,0,0,.2);overflow:hidden;margin:16px;
                animation:modalIn .2s ease;">
        <div style="padding:24px 24px 0;">
            <div style="width:48px;height:48px;background:#fef2f2;border-radius:12px;
                        display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <i class="fas fa-user-times" style="color:#ef4444;font-size:1.1rem;"></i>
            </div>
            <div style="font-size:1rem;font-weight:700;color:#1a202c;margin-bottom:6px;">Delete user?</div>
            <div id="deleteUserName" style="font-size:.875rem;color:#64748b;line-height:1.55;">
                This user will be permanently deleted and cannot be recovered.
            </div>
        </div>
        <div style="padding:20px 24px 24px;display:flex;gap:10px;justify-content:flex-end;">
            <button id="deleteUserCancel" style="
                padding:8px 18px;border-radius:8px;border:1px solid #e2e8f0;
                background:#fff;color:#475569;font-size:.875rem;font-weight:500;cursor:pointer;">
                Cancel
            </button>
            <button id="deleteUserConfirm" style="
                padding:8px 18px;border-radius:8px;border:none;
                background:#ef4444;color:#fff;font-size:.875rem;font-weight:600;cursor:pointer;
                transition:background .15s;">
                <i class="fas fa-trash mr-1"></i> Delete
            </button>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(.95) translateY(8px); }
    to   { opacity:1; transform:scale(1)  translateY(0); }
}
#deleteUserConfirm:hover { background:#dc2626 !important; }
</style>
@endsection

@push('scripts')
<script>
let _deleteUrl = null, _deleteRow = null;

$(document).on('click', '.btn-delete-user', function () {
    _deleteUrl = $(this).data('url');
    _deleteRow = $(this).closest('tr');
    const name = $(this).data('name');
    $('#deleteUserName').text(`"${name}" will be permanently deleted and cannot be recovered.`);
    $('#deleteUserModal').css('display', 'flex');
});

$('#deleteUserCancel').on('click', function () {
    $('#deleteUserModal').hide();
    _deleteUrl = null; _deleteRow = null;
});

$('#deleteUserModal').on('click', function (e) {
    if (e.target === this) { $(this).hide(); _deleteUrl = null; _deleteRow = null; }
});

$('#deleteUserConfirm').on('click', function () {
    if (!_deleteUrl) return;
    const btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Deleting…').prop('disabled', true);
    $.ajax({ url: _deleteUrl, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
        success: res => {
            if (res.success) {
                _deleteRow.fadeOut(300, () => _deleteRow.remove());
                $('#deleteUserModal').hide();
            }
        },
        complete: () => btn.html('<i class="fas fa-trash mr-1"></i> Delete').prop('disabled', false)
    });
});

$(document).on('click', '.btn-toggle-role', function () {
    const btn = $(this), row = btn.closest('tr');
    $.ajax({ url: btn.data('url'), type: 'PATCH', data: { _token: '{{ csrf_token() }}' },
        success: res => {
            if (res.success) {
                const isAdmin = res.role === 'admin';
                row.find('.role-badge').html(isAdmin
                    ? '<span style="width:6px;height:6px;background:#ef4444;border-radius:50%;"></span>Admin'
                    : '<span style="width:6px;height:6px;background:#94a3b8;border-radius:50%;"></span>User'
                ).attr('style', isAdmin
                    ? 'background:#fef2f2;color:#b91c1c;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;'
                    : 'background:#f1f5f9;color:#475569;border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;display:inline-flex;align-items:center;gap:5px;'
                );
            }
        }
    });
});
</script>
@endpush
