@extends('layouts.app')
@section('title', 'Contact Us')
@php($hideGlobalAlert = true)

@section('content')

<div class="container pb-5">
    <div style="background:linear-gradient(135deg,#280905,#740A03);color:#fff;border-radius:8px;padding:20px 24px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        <i class="fas fa-envelope" style="color:#E6501B;font-size:1.6rem;"></i>
        <h2 style="margin:0;font-size:1.5rem;font-weight:700;">Contact Us</h2>
    </div>
    <div class="row">
        <div class="col-md-7">


            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;">
                <div style="background:#280905;padding:1rem 1.5rem;">
                    <h5 style="color:#fff;margin:0;font-weight:600;"><i class="fas fa-paper-plane me-2" style="color:#E6501B;"></i>Send a Message</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('contact.store') }}" id="contactForm" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold" style="color:#740A03;">Your Name *</label>
                                <input type="text" name="name" id="contactName" class="form-control @error('name') is-invalid @enderror"
                                       style="border-color:#C3110C;border-radius:8px;"
                                       value="{{ old('name', auth()->user()?->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <span class="contact-field-error" id="nameError" style="color:#C3110C;font-size:.82rem;display:none;"></span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color:#740A03;">Email Address *</label>
                                <input type="email" name="email" id="contactEmail" class="form-control @error('email') is-invalid @enderror"
                                       style="border-color:#C3110C;border-radius:8px;"
                                       value="{{ old('email', auth()->user()?->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                    <span class="contact-field-error" id="emailError" style="color:#C3110C;font-size:.82rem;display:none;"></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color:#740A03;">Subject *</label>
                            <input type="text" name="subject" id="contactSubject" class="form-control @error('subject') is-invalid @enderror"
                                   style="border-color:#C3110C;border-radius:8px;"
                                   value="{{ old('subject') }}">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <span class="contact-field-error" id="subjectError" style="color:#C3110C;font-size:.82rem;display:none;"></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color:#740A03;">
                                Message * <small style="color:#888;font-weight:400;">(min. 20 characters)</small>
                            </label>
                            <textarea name="message" id="contactMessage" class="form-control @error('message') is-invalid @enderror"
                                      style="border-color:#C3110C;border-radius:8px;"
                                      rows="6">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <span class="contact-field-error" id="messageError" style="color:#C3110C;font-size:.82rem;display:none;"></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary px-5 py-2" style="border-radius:8px;font-weight:600;">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>

                    <script>
                    document.getElementById('contactForm').addEventListener('submit', function (e) {
                        let valid = true;

                        function fieldError(inputId, errorId, msg) {
                            const el = document.getElementById(errorId);
                            if (!el) return;
                            if (msg) {
                                el.textContent = msg;
                                el.style.display = 'block';
                                document.getElementById(inputId).style.borderColor = '#C3110C';
                                valid = false;
                            } else {
                                el.style.display = 'none';
                            }
                        }

                        const name    = document.getElementById('contactName').value.trim();
                        const email   = document.getElementById('contactEmail').value.trim();
                        const subject = document.getElementById('contactSubject').value.trim();
                        const message = document.getElementById('contactMessage').value.trim();

                        fieldError('contactName',    'nameError',    name    === '' ? 'Please enter your name.'    : null);
                        fieldError('contactEmail',   'emailError',   email   === '' ? 'Please enter your email.'   :
                                                                      !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) ? 'Please enter a valid email address.' : null);
                        fieldError('contactSubject', 'subjectError', subject === '' ? 'Please enter a subject.'   : null);
                        fieldError('contactMessage', 'messageError', message === '' ? 'Please write your message.' :
                                                                      message.length < 20 ? 'Message must be at least 20 characters.' : null);

                        if (!valid) e.preventDefault();
                    });
                    </script>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4 offset-md-1 mt-4 mt-md-0">
            <div class="card border-0 shadow-sm mb-3" style="border-radius:12px;overflow:hidden;">
                <div style="background:#280905;padding:1rem 1.5rem;">
                    <h5 style="color:#fff;margin:0;font-weight:600;"><i class="fas fa-address-card me-2" style="color:#E6501B;"></i>Get In Touch</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex gap-3 mb-4">
                        <div style="width:42px;height:42px;background:#C3110C;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-envelope" style="color:#fff;"></i>
                        </div>
                        <div>
                            <strong style="color:#280905;">Email</strong><br>
                            <span style="color:#555;">support@laravelshop.com</span>
                        </div>
                    </div>
                    <div class="d-flex gap-3">
                        <div style="width:42px;height:42px;background:#740A03;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-clock" style="color:#fff;"></i>
                        </div>
                        <div>
                            <strong style="color:#280905;">Business Hours</strong><br>
                            <span style="color:#555;">Mon–Fri, 9am–5pm</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;border-left:4px solid #E6501B !important;">
                <div class="card-body p-4" style="background:#fff8f7;">
                    <h6 style="color:#740A03;font-weight:700;margin-bottom:.5rem;"><i class="fas fa-info-circle me-2" style="color:#E6501B;"></i>Response Time</h6>
                    <p style="color:#555;margin:0;font-size:.9rem;">We typically respond within <strong style="color:#C3110C;">24 hours</strong> on business days.</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Toast --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="contactToast" class="toast align-items-center text-white border-0" style="background:#C3110C;">
        <div class="d-flex">
            <div class="toast-body"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Toast(document.getElementById('contactToast'), { delay: 4000 }).show();
    });
</script>
@endif
@endsection
