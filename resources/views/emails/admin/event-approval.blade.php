@extends('emails.admin.adminLayouts.app')

@section('title', 'New Event Submission for Approval')

@section('content')
    <div class="email-body">
        <h2 style="color: #e3342f;">🚨 New Event Submitted for Approval</h2>
        <p>Hi Admin,</p>

        <p>A vendor has just published a new event that requires your review and approval:</p>

        <ul>
            <li><strong>📄 Event Name:</strong> {{ $event->name }}</li>
            <li><strong>🎤 Vendor:</strong> {{ $event->vendor->vendor_name ?? 'N/A' }}</li>
            <li><strong>📧 Vendor Email:</strong> {{ $event->vendor->vendor_email ?? 'N/A' }}</li>
            <li><strong>📅 Proposed Date & Time:</strong>
                {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y g:i A') }}</li>
            <li><strong>📂 Event Type:</strong> {{ $event->category->name }}</li>
        </ul>

        <p>
            <a href="{{ route('admin.curative-experiences.show', $event->id) }}"
                style="display: inline-block; background-color: #38c172; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
                👉 Review & Approve Event
            </a>
        </p>

        <p>Thanks,<br>Your System</p>
    </div>
@endsection