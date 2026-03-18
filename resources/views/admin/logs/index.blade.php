@extends('layouts.admin')
@section('title', 'Activity Logs')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Activity Logs</h3>
    </div>
    <div class="card-body">
        <form class="mb-3 d-flex flex-wrap gap-2 align-items-end" method="GET">
            <div>
                <label class="d-block small">From</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
            </div>
            <div>
                <label class="d-block small">To</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
            </div>
            <div>
                <label class="d-block small">Action</label>
                <select name="action" class="form-control form-control-sm">
                    <option value="">All actions</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                            {{ $action }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-sm btn-secondary align-self-end" type="submit">Filter</button>
            @if(request()->hasAny(['from','to','action']))
                <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-secondary align-self-end">Clear</a>
            @endif
        </form>

        <table class="table table-hover table-sm">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                    <td>{{ $log->user?->name ?? '<em>Guest</em>' }}</td>
                    <td><span class="badge badge-info">{{ $log->action }}</span></td>
                    <td>{{ $log->description }}</td>
                    <td><code>{{ $log->ip_address }}</code></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">No logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $logs->links() }}
    </div>
</div>
@endsection
