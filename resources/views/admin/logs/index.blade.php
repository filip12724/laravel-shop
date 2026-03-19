@extends('layouts.admin')
@section('title', 'Activity Logs')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-history mr-2" style="color:#4f46e5;"></i>Activity Logs</h3>
    </div>
    <div class="card-body">
        <div class="admin-filter-bar" style="padding:16px 18px;">
            <form class="w-100" method="GET">
                <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">

                    {{-- Date range --}}
                    <div style="display:flex;align-items:flex-end;gap:8px;flex-wrap:wrap;">
                        <div>
                            <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                                <i class="fas fa-calendar-alt mr-1" style="color:#4f46e5;"></i>From
                            </label>
                            <div style="position:relative;">
                                <input type="date" name="from"
                                       value="{{ request('from') }}"
                                       style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;width:148px;cursor:pointer;"
                                       onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                                       onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div style="padding-bottom:10px;color:#94a3b8;font-size:.9rem;">
                            <i class="fas fa-arrow-right"></i>
                        </div>

                        <div>
                            <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                                <i class="fas fa-calendar-alt mr-1" style="color:#4f46e5;"></i>To
                            </label>
                            <input type="date" name="to"
                                   value="{{ request('to') }}"
                                   style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;width:148px;cursor:pointer;"
                                   onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                                   onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div style="width:1px;height:36px;background:#e2e8f0;align-self:flex-end;margin-bottom:2px;"></div>

                    {{-- Action select --}}
                    <div>
                        <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                            <i class="fas fa-bolt mr-1" style="color:#4f46e5;"></i>Action
                        </label>
                        <select name="action"
                                style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;min-width:160px;cursor:pointer;"
                                onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            <option value="">All actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div style="display:flex;gap:8px;align-self:flex-end;">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-filter mr-1"></i> Apply
                        </button>
                        @if(request()->hasAny(['from','to','action']))
                            <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Clear
                            </a>
                        @endif
                    </div>

                </div>

                {{-- Active filter summary --}}
                @if(request()->hasAny(['from','to','action']))
                <div style="margin-top:12px;display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                    <span style="font-size:.72rem;color:#94a3b8;font-weight:600;">Active filters:</span>
                    @if(request('from'))
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:2px 10px;font-size:.75rem;font-weight:600;">
                            From: {{ request('from') }}
                        </span>
                    @endif
                    @if(request('to'))
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:2px 10px;font-size:.75rem;font-weight:600;">
                            To: {{ request('to') }}
                        </span>
                    @endif
                    @if(request('action'))
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:2px 10px;font-size:.75rem;font-weight:600;">
                            Action: {{ request('action') }}
                        </span>
                    @endif
                </div>
                @endif
            </form>
        </div>

        <table class="table table-hover">
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
                    <td style="color:#94a3b8;font-size:.82rem;white-space:nowrap;">{{ $log->created_at->format('M d, Y H:i') }}</td>
                    <td style="font-weight:500;">{{ $log->user?->name ?? '<em class="text-muted">Guest</em>' }}</td>
                    <td><span style="background:#eef2ff;color:#4338ca;border-radius:6px;padding:3px 8px;font-size:.75rem;font-weight:600;">{{ $log->action }}</span></td>
                    <td style="font-size:.875rem;color:#2d3748;">{{ $log->description }}</td>
                    <td><code>{{ $log->ip_address }}</code></td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center" style="padding:32px;color:#94a3b8;">No logs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $logs->links('vendor.pagination.bootstrap-4') }}</div>
</div>
@endsection
