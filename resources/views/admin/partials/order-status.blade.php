@php
$colors = [
    'pending'    => 'warning',
    'processing' => 'info',
    'shipped'    => 'primary',
    'delivered'  => 'success',
    'cancelled'  => 'danger',
];
@endphp
<span class="badge badge-{{ $colors[$status] ?? 'secondary' }}">{{ ucfirst($status) }}</span>
