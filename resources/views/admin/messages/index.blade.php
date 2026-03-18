@extends('layouts.admin')
@section('title', 'Contact Messages')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Contact Messages</h3>
        @if($unreadCount > 0)
            <span class="badge badge-danger">{{ $unreadCount }} unread</span>
        @endif
    </div>
    <div class="card-body">
        <form class="mb-3" method="GET">
            <div class="custom-control custom-checkbox d-inline-block">
                <input type="checkbox" class="custom-control-input" id="unread" name="unread" value="1"
                    {{ request('unread') ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="custom-control-label" for="unread">Show unread only</label>
            </div>
        </form>

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th></th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr class="{{ !$msg->read ? 'font-weight-bold' : '' }}">
                    <td>
                        @if(!$msg->read)
                            <span class="badge badge-danger">New</span>
                        @endif
                    </td>
                    <td>{{ $msg->name }}<br><small class="text-muted">{{ $msg->email }}</small></td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}">{{ $msg->subject }}</a>
                    </td>
                    <td>{{ $msg->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-xs btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-xs btn-danger btn-delete-msg"
                                data-url="{{ route('admin.messages.destroy', $msg) }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No messages.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $messages->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '.btn-delete-msg', function () {
    const url = $(this).data('url');
    const row = $(this).closest('tr');

    if (!confirm('Delete this message?')) return;

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
