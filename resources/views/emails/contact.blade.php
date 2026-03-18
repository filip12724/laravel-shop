<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Contact Message</title></head>
<body style="font-family:sans-serif;max-width:600px;margin:0 auto;padding:20px;">
    <h2 style="color:#333;">New Contact Message</h2>
    <hr>

    <p><strong>From:</strong> {{ $contact->name }} ({{ $contact->email }})</p>
    <p><strong>Subject:</strong> {{ $contact->subject }}</p>
    <p><strong>Received:</strong> {{ $contact->created_at->format('F d, Y H:i') }}</p>

    <hr>

    <h3>Message:</h3>
    <p style="white-space:pre-wrap;background:#f5f5f5;padding:15px;border-radius:4px;">{{ $contact->message }}</p>

    <hr>
    <p style="color:#999;font-size:12px;">
        This message was sent via the Laravel Shop contact form.
        Reply directly to {{ $contact->email }}.
    </p>
</body>
</html>
