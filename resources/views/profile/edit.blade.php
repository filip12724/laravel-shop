@extends('layouts.app')

@section('title', 'My Profile — ' . config('app.name'))

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Page header --}}
        <div style="background:linear-gradient(135deg,#280905,#740A03);color:#fff;border-radius:8px;padding:20px 24px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
            <div style="background:rgba(255,255,255,.12);border-radius:50%;width:48px;height:48px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <span style="font-size:1.25rem;font-weight:700;color:#fff;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div>
                <h4 class="mb-0 fw-bold">{{ auth()->user()->name }}</h4>
                <small style="color:#f5d5c8;opacity:.85;">{{ auth()->user()->email }}</small>
            </div>
        </div>

        {{-- Profile Information --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:10px;overflow:hidden;">
            <div class="card-header py-3" style="background:#f7f0ef;border-bottom:3px solid #C3110C;">
                <h6 class="mb-0 fw-bold" style="color:#280905;">
                    <i class="fas fa-user me-2" style="color:#C3110C;"></i>Profile Information
                </h6>
                <small class="text-muted">Update your name and email address.</small>
            </div>
            <div class="card-body p-4">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:10px;overflow:hidden;">
            <div class="card-header py-3" style="background:#f7f0ef;border-bottom:3px solid #C3110C;">
                <h6 class="mb-0 fw-bold" style="color:#280905;">
                    <i class="fas fa-lock me-2" style="color:#C3110C;"></i>Update Password
                </h6>
                <small class="text-muted">Use a long, random password to keep your account secure.</small>
            </div>
            <div class="card-body p-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:10px;overflow:hidden;">
            <div class="card-header py-3" style="background:#fff5f5;border-bottom:3px solid #dc3545;">
                <h6 class="mb-0 fw-bold" style="color:#7a1020;">
                    <i class="fas fa-trash-alt me-2" style="color:#dc3545;"></i>Delete Account
                </h6>
                <small class="text-muted">Permanently delete your account and all associated data.</small>
            </div>
            <div class="card-body p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>

@endsection
