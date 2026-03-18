@extends('layouts.admin')
@section('title', 'Users')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Users</h3>
    </div>
    <div class="card-body">
        <form class="mb-3 d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search..." value="{{ request('search') }}">
            <button class="btn btn-sm btn-secondary" type="submit">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Clear</a>
            @endif
        </form>

        <table class="table table-hover table-sm">
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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-{{ $user->isAdmin() ? 'danger' : 'secondary' }} role-badge">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($user->id !== auth()->id())
                        <button class="btn btn-xs btn-warning btn-toggle-role"
                                data-url="{{ route('admin.users.toggle-role', $user) }}"
                                title="Toggle role">
                            <i class="fas fa-user-cog"></i>
                        </button>
                        <button class="btn btn-xs btn-danger btn-delete-user"
                                data-url="{{ route('admin.users.destroy', $user) }}"
                                data-name="{{ $user->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-toggle-role', function () {
    const btn  = $(this);
    const url  = btn.data('url');
    const row  = btn.closest('tr');

    $.ajax({
        url,
        type: 'PATCH',
        data: { _token: '{{ csrf_token() }}' },
        success: function (res) {
            if (res.success) {
                const badge = row.find('.role-badge');
                badge.text(res.role.charAt(0).toUpperCase() + res.role.slice(1));
                badge.removeClass('badge-danger badge-secondary')
                     .addClass(res.role === 'admin' ? 'badge-danger' : 'badge-secondary');
            }
        }
    });
});

$(document).on('click', '.btn-delete-user', function () {
    const url  = $(this).data('url');
    const name = $(this).data('name');
    const row  = $(this).closest('tr');

    if (!confirm(`Delete user "${name}"?`)) return;

    $.ajax({
        url,
        type: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function (res) {
            if (res.success) row.fadeOut(300, () => row.remove());
        }
    });
});
</script>
@endpush
