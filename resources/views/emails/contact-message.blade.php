<div style="font-family: Arial, sans-serif; font-size: 14px; color: #222;">
    <h2 style="margin: 0 0 12px;">New contact message</h2>
    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><td><strong>Name</strong></td><td>{{ $contactMessage->name }}</td></tr>
        <tr><td><strong>Phone / email</strong></td><td>{{ $contactMessage->contact }}</td></tr>
        <tr><td><strong>Subject</strong></td><td>{{ $contactMessage->subject ?: '—' }}</td></tr>
        <tr><td><strong>Message</strong></td><td>{!! nl2br(e($contactMessage->message)) !!}</td></tr>
        <tr><td><strong>Submitted</strong></td><td>{{ $contactMessage->created_at->format('d M Y, h:i A') }}</td></tr>
    </table>
    <p style="color: #777;">You can also see this in the admin panel under Contact Messages.</p>
</div>
