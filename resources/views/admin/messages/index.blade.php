@extends('layouts.admin')
@section('title', 'Contact Messages')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-envelope mr-2" style="color:#4f46e5;"></i>Contact Messages</h3>
        @if($unreadCount > 0)
            <span style="background:#fef2f2;color:#b91c1c;border-radius:20px;padding:4px 12px;font-size:.78rem;font-weight:700;">
                {{ $unreadCount }} unread
            </span>
        @endif
    </div>
    <div class="card-body">
        <div class="admin-filter-bar">
            <form method="GET">
                <label style="cursor:pointer;margin:0;display:inline-flex;align-items:center;gap:10px;
                              background:#fff;border:1px solid #e2e8f0;border-radius:8px;
                              padding:8px 14px;transition:border-color .15s;">
                    <input type="checkbox" name="unread" value="1"
                           {{ request('unread') ? 'checked' : '' }}
                           onchange="this.form.submit()"
                           style="width:16px;height:16px;accent-color:#4f46e5;flex-shrink:0;cursor:pointer;">
                    <span style="font-size:.875rem;font-weight:500;color:#2d3748;user-select:none;">
                        Show unread only
                    </span>
                    @if(request('unread'))
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:2px 8px;font-size:.72rem;font-weight:700;">ON</span>
                    @endif
                </label>
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="60"></th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr style="{{ !$msg->read ? 'background:#fafbfe;' : '' }}">
                    <td>
                        @if(!$msg->read)
                            <span style="background:#fef2f2;color:#b91c1c;border-radius:20px;padding:2px 8px;font-size:.7rem;font-weight:700;">New</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:{{ !$msg->read ? '700' : '500' }};">{{ $msg->name }}</div>
                        <small style="color:#94a3b8;">{{ $msg->email }}</small>
                    </td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}"
                           style="color:#2d3748;font-weight:{{ !$msg->read ? '700' : '400' }};text-decoration:none;">
                            {{ $msg->subject }}
                        </a>
                    </td>
                    <td style="color:#94a3b8;font-size:.82rem;white-space:nowrap;">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-xs btn-info mr-1">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-xs btn-danger btn-delete-msg"
                                data-url="{{ route('admin.messages.destroy', $msg) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center" style="padding:32px;color:#94a3b8;">No messages.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $messages->links('vendor.pagination.bootstrap-4') }}</div>
</div>

{{-- Delete confirmation modal --}}
<div id="deleteMsgModal" style="
    display:none;position:fixed;inset:0;z-index:9999;
    background:rgba(15,23,42,.45);backdrop-filter:blur(3px);
    align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:100%;max-width:400px;
                box-shadow:0 24px 60px rgba(0,0,0,.2);overflow:hidden;margin:16px;
                animation:modalIn .2s ease;">
        <div style="padding:24px 24px 0;">
            <div style="width:48px;height:48px;background:#fef2f2;border-radius:12px;
                        display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <i class="fas fa-trash" style="color:#ef4444;font-size:1.1rem;"></i>
            </div>
            <div style="font-size:1rem;font-weight:700;color:#1a202c;margin-bottom:6px;">Delete message?</div>
            <div style="font-size:.875rem;color:#64748b;line-height:1.55;">
                This message will be permanently deleted and cannot be recovered.
            </div>
        </div>
        <div style="padding:20px 24px 24px;display:flex;gap:10px;justify-content:flex-end;">
            <button id="deleteMsgCancel" style="
                padding:8px 18px;border-radius:8px;border:1px solid #e2e8f0;
                background:#fff;color:#475569;font-size:.875rem;font-weight:500;cursor:pointer;">
                Cancel
            </button>
            <button id="deleteMsgConfirm" style="
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
#deleteMsgConfirm:hover { background:#dc2626 !important; }
</style>
@endsection

@push('scripts')
<script>
let _deleteUrl = null, _deleteRow = null;

$(document).on('click', '.btn-delete-msg', function () {
    _deleteUrl = $(this).data('url');
    _deleteRow = $(this).closest('tr');
    $('#deleteMsgModal').css('display', 'flex');
});

$('#deleteMsgCancel').on('click', function () {
    $('#deleteMsgModal').hide();
    _deleteUrl = null; _deleteRow = null;
});

$('#deleteMsgModal').on('click', function (e) {
    if (e.target === this) { $(this).hide(); _deleteUrl = null; _deleteRow = null; }
});

$('#deleteMsgConfirm').on('click', function () {
    if (!_deleteUrl) return;
    const btn = $(this);
    btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Deleting…').prop('disabled', true);
    $.ajax({ url: _deleteUrl, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
        success: res => {
            if (res.success) {
                _deleteRow.fadeOut(300, () => _deleteRow.remove());
                $('#deleteMsgModal').hide();
            }
        },
        complete: () => btn.html('<i class="fas fa-trash mr-1"></i> Delete').prop('disabled', false)
    });
});
</script>
@endpush
