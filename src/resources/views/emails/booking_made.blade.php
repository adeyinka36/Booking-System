<p>Hi {{ $booking->user->name}}, We have received your booking for <stron>{{ $booking->booking_date }}</stron> at <strong>{{ $booking->booking_time }}</strong>.</p>
<p>Please Email <strong>{{ config('emails.admin_email') }}</strong> for any changes. </p>
<p>Thanks, {{ config('app.name') }}</p>
