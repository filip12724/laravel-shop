@props(['status'])

@if ($status)
    <div style="background:#fdf5f4;border-left:4px solid #C3110C;border-radius:6px;padding:10px 14px;margin-bottom:1rem;font-size:.875rem;color:#740A03;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-check-circle" style="color:#C3110C;"></i>
        {{ $status }}
    </div>
@endif
