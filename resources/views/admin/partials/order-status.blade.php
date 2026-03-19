@php
$map = [
    'pending'    => ['bg' => '#fffbeb', 'color' => '#d97706', 'dot' => '#f59e0b'],
    'processing' => ['bg' => '#eff6ff', 'color' => '#2563eb', 'dot' => '#3b82f6'],
    'shipped'    => ['bg' => '#eef2ff', 'color' => '#4338ca', 'dot' => '#4f46e5'],
    'delivered'  => ['bg' => '#f0fdf4', 'color' => '#15803d', 'dot' => '#10b981'],
    'cancelled'  => ['bg' => '#fef2f2', 'color' => '#b91c1c', 'dot' => '#ef4444'],
];
$s = $map[$status] ?? ['bg' => '#f1f5f9', 'color' => '#64748b', 'dot' => '#94a3b8'];
@endphp
<span style="display:inline-flex;align-items:center;gap:5px;background:{{ $s['bg'] }};color:{{ $s['color'] }};border-radius:20px;padding:3px 10px;font-size:.75rem;font-weight:600;">
    <span style="width:6px;height:6px;background:{{ $s['dot'] }};border-radius:50%;flex-shrink:0;"></span>
    {{ ucfirst($status) }}
</span>
