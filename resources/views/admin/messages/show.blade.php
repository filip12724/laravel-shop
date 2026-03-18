@extends('layouts.admin')
@section('title', 'Message: ' . $contactMessage->subject)

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">{{ $contactMessage->subject }}</h3>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>
    <div class="card-body">
        <dl class="row mb-3">
            <dt class="col-sm-2">From</dt>
            <dd class="col-sm-10">{{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;</dd>
            <dt class="col-sm-2">Date</dt>
            <dd class="col-sm-10">{{ $contactMessage->created_at->format('M d, Y H:i') }}</dd>
        </dl>
        <hr>
        <div style="white-space:pre-wrap;">{{ $contactMessage->message }}</div>
    </div>
    <div class="card-footer">
        <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ urlencode($contactMessage->subject) }}" class="btn btn-primary">
            <i class="fas fa-reply mr-1"></i> Reply via Email
        </a>
    </div>
</div>
@endsection
