<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Reset Your Password</title></head>
<body style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:0;background:#f5f5f5;">

    <!-- Header -->
    <div style="background:linear-gradient(135deg,#280905,#740A03);padding:28px 32px;border-radius:8px 8px 0 0;">
        <h1 style="margin:0;color:#fff;font-size:1.4rem;letter-spacing:.02em;">
            🛒 WildCart
        </h1>
        <p style="margin:6px 0 0;color:#c9a09a;font-size:.875rem;">Password Reset Request</p>
    </div>

    <!-- Body -->
    <div style="background:#fff;padding:32px;border-radius:0 0 8px 8px;box-shadow:0 2px 12px rgba(0,0,0,.08);">

        <p style="margin:0 0 16px;color:#333;font-size:.95rem;">Hi there,</p>
        <p style="margin:0 0 24px;color:#555;font-size:.9rem;line-height:1.6;">
            We received a request to reset your WildCart password. Click the button below to choose a new one.
            This link will expire in <strong style="color:#280905;">60 minutes</strong>.
        </p>

        <!-- Reset button -->
        <div style="text-align:center;margin:0 0 28px;">
            <a href="{{ $resetUrl }}"
               style="display:inline-block;background:linear-gradient(135deg,#C3110C,#740A03);color:#fff;text-decoration:none;padding:12px 32px;border-radius:6px;font-weight:700;font-size:.95rem;letter-spacing:.03em;">
                Reset Password
            </a>
        </div>

        <p style="margin:0 0 16px;color:#555;font-size:.85rem;line-height:1.6;">
            If you didn't request a password reset, no action is needed — your password will remain unchanged.
        </p>

        <!-- Fallback URL -->
        <div style="background:#f9f9f9;border-radius:6px;padding:14px 16px;font-size:.8rem;color:#888;line-height:1.7;">
            If the button above doesn't work, copy and paste this link into your browser:<br>
            <a href="{{ $resetUrl }}" style="color:#C3110C;word-break:break-all;">{{ $resetUrl }}</a>
        </div>
    </div>

    <!-- Footer -->
    <div style="text-align:center;padding:20px;color:#999;font-size:.78rem;">
        &copy; {{ date('Y') }} WildCart &mdash; All rights reserved.<br>
        This email was sent because a password reset was requested for your account.
    </div>

</body>
</html>
