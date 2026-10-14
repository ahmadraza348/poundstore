<div style="font-family: Arial, sans-serif; font-size: 14px; color: #222;">
    <h2 style="margin: 0 0 12px;">New franchise enquiry</h2>
    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; border-color: #ddd;">
        <tr><td><strong>Name</strong></td><td>{{ $enquiry->name }}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{{ $enquiry->phone }}</td></tr>
        <tr><td><strong>Email</strong></td><td>{{ $enquiry->email ?: '—' }}</td></tr>
        <tr><td><strong>City / location</strong></td><td>{{ $enquiry->city }}</td></tr>
        <tr><td><strong>Investment preference</strong></td><td>{{ $enquiry->budget ?: '—' }}</td></tr>
        <tr><td><strong>Property status</strong></td><td>{{ $enquiry->property_status ?: '—' }}</td></tr>
        <tr><td><strong>Notes</strong></td><td>{!! nl2br(e($enquiry->notes ?: '—')) !!}</td></tr>
        <tr><td><strong>Submitted</strong></td><td>{{ $enquiry->created_at->format('d M Y, h:i A') }}</td></tr>
    </table>
    <p style="color: #777;">You can also see this in the admin panel under Franchise Enquiries.</p>
</div>
