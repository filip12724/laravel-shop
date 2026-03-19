@extends('layouts.admin')
@section('title', 'Message: ' . $contactMessage->subject)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h3 class="card-title">
                    <i class="fas fa-envelope-open mr-2" style="color:#4f46e5;"></i>
                    {{ $contactMessage->subject }}
                </h3>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div style="display:flex;gap:24px;margin-bottom:20px;flex-wrap:wrap;">
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:4px;">From</div>
                        <div style="font-weight:600;color:#1a202c;">{{ $contactMessage->name }}</div>
                        <div style="color:#4f46e5;font-size:.875rem;">{{ $contactMessage->email }}</div>
                    </div>
                    <div>
                        <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:4px;">Date</div>
                        <div style="font-weight:500;color:#2d3748;">{{ $contactMessage->created_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
                <div style="border-top:1px solid #f0f3f9;padding-top:18px;">
                    <div style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:10px;">Message</div>
                    <div style="white-space:pre-wrap;line-height:1.75;color:#2d3748;font-size:.9rem;background:#f7f9fe;border-radius:10px;padding:16px 18px;">{{ $contactMessage->message }}</div>
                </div>
            </div>
            <div class="card-footer">
                <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ urlencode($contactMessage->subject) }}"
                   class="btn btn-primary">
                    <i class="fas fa-reply mr-1"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
