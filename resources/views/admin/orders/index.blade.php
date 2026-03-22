@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-shopping-cart mr-2" style="color:#4f46e5;"></i>Orders</h3>
    </div>
    <div class="card-body">
        <div class="admin-filter-bar" style="padding:16px 18px;">
            <form method="GET" style="width:100%;">
                <div style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end;">

                    {{-- Customer search --}}
                    <div>
                        <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                            <i class="fas fa-user mr-1" style="color:#4f46e5;"></i>Customer
                        </label>
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by name or email…"
                               style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;width:220px;"
                               onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                               onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                    </div>

                    {{-- Divider --}}
                    <div style="width:1px;height:36px;background:#e2e8f0;align-self:flex-end;margin-bottom:2px;"></div>

                    {{-- Status --}}
                    <div>
                        <label style="display:block;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:5px;">
                            <i class="fas fa-tag mr-1" style="color:#4f46e5;"></i>Status
                        </label>
                        <select name="status"
                                style="padding:7px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:.85rem;color:#2d3748;background:#fff;outline:none;min-width:160px;cursor:pointer;"
                                onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,.12)'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            <option value="">All statuses</option>
                            @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div style="display:flex;gap:8px;align-self:flex-end;">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-filter mr-1"></i> Apply
                        </button>
                        @if(request()->hasAny(['search','status']))
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times mr-1"></i> Clear
                            </a>
                        @endif
                    </div>

                </div>

                {{-- Active filter summary --}}
                @if(request()->hasAny(['search','status']))
                <div style="margin-top:12px;display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                    <span style="font-size:.72rem;color:#94a3b8;font-weight:600;">Active filters:</span>
                    @if(request('search'))
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:2px 10px;font-size:.75rem;font-weight:600;">
                            Customer: {{ request('search') }}
                        </span>
                    @endif
                    @if(request('status'))
                        <span style="background:#eef2ff;color:#4338ca;border-radius:20px;padding:2px 10px;font-size:.75rem;font-weight:600;">
                            Status: {{ ucfirst(request('status')) }}
                        </span>
                    @endif
                </div>
                @endif
            </form>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="font-weight:700;color:#4f46e5;">#{{ $order->id }}</td>
                    <td>
                        <div style="font-weight:600;font-size:.875rem;">{{ $order->user?->name ?? 'Guest' }}</div>
                        <small style="color:#94a3b8;">{{ $order->user?->email ?? $order->guest_email ?? '—' }}</small>
                    </td>
                    <td style="font-weight:700;">${{ number_format($order->total, 2) }}</td>
                    <td>@include('admin.partials.order-status', ['status' => $order->status])</td>
                    <td style="color:#94a3b8;font-size:.82rem;">{{ $order->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-xs btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center" style="padding:32px;color:#94a3b8;">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $orders->links('vendor.pagination.bootstrap-4') }}</div>
</div>
@endsection
