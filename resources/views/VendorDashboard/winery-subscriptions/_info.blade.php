<p><strong>Current Plan:</strong> {{ $subscription->stripe_plan_id ?? 'None' }}</p>
<p><strong>Status:</strong> {{ $subscription->status ?? 'Inactive' }}</p>
<p><strong>Expires On:</strong> {{ $subscription->end_date ? $subscription->end_date->format('Y-m-d') : 'N/A' }}</p>
