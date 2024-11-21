<h1>New Contact Us Message</h1>
<p><strong>First Name:</strong> {{ $fname }}</p>
<p><strong>Last Name:</strong> {{ $lname }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Phone:</strong> {{ $phone }}</p>
<p><strong>Subject:</strong> {{ $subject }}</p>
<p><strong>Message:</strong> {{ $message }}</p>

{{-- Debug Output --}}
<pre>{{ print_r($data, true) }}</pre>