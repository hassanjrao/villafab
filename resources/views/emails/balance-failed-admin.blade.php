<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Issue (Admin)</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="700" cellpadding="0" cellspacing="0"
                    style="max-width:700px;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="padding:20px 24px;background:#1f2937;color:#ffffff;font-size:20px;font-weight:700;">
                            Payment Failed – Booking #{{ $booking->id }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 24px;font-size:14px;line-height:1.6;">

                            <p style="margin:0 0 12px;">Hello Admin,</p>
                            <p style="margin:0 0 16px;">The automatic balance charge for the following booking has <strong>failed</strong>. The guest has been notified.</p>

                            {{-- Booking ID --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #dbe7ef;border-radius:8px;">
                                <tr>
                                    <td style="padding:12px 14px;background:#f8fcff;">
                                        <strong>Booking ID:</strong> #{{ $booking->id }}<br>
                                        <strong>Notified At:</strong> {{ $booking->balance_failure_notified_at ? $booking->balance_failure_notified_at->format('F j, Y g:i A') : now()->format('F j, Y g:i A') }}
                                    </td>
                                </tr>
                            </table>

                            {{-- Guest Information --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        👤 Guest Information</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Full Name</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">{{ $booking->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Email Address</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">{{ $booking->email ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;"><strong>Phone Number</strong></td>
                                    <td style="padding:8px 0;" align="right">{{ $booking->phone ?: '-' }}</td>
                                </tr>
                            </table>

                            {{-- Reservation Details --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        🏠 Reservation Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Property</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">Villa Fabulosa</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Check-in Date</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->checkin ? $booking->checkin->format('l, F j, Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Check-out Date</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->checkout ? $booking->checkout->format('l, F j, Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Number of Nights</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">{{ $booking->nights }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;"><strong>Total Guests</strong></td>
                                    <td style="padding:8px 0;" align="right">{{ $booking->guests }}</td>
                                </tr>
                            </table>

                            {{-- Payment Details --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        💳 Payment Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount Due</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->balance_due, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Attempted Charge Date</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->balance_failure_notified_at ? $booking->balance_failure_notified_at->format('l, F j, Y') : now()->format('l, F j, Y') }}</td>
                                </tr>
                                @if(!empty($cardDetails['brand']) || !empty($cardDetails['last4']))
                                <tr>
                                    <td style="padding:8px 0;" colspan="2">
                                        <strong>Payment Method on File:</strong><br>
                                        {{ $cardDetails['brand'] ?? 'Card' }} ending in {{ $cardDetails['last4'] ?? '****' }}<br>
                                        Expiration: {{ $cardDetails['exp_month'] ?? '--' }}/{{ $cardDetails['exp_year'] ?? '----' }}
                                    </td>
                                </tr>
                                @endif
                            </table>

                            @if($booking->card_update_token)
                            <p style="margin:0 0 0;font-size:13px;color:#6b7280;">
                                <strong>Guest update-card link:</strong><br>
                                <a href="{{ route('booking.update-card', $booking->card_update_token) }}">{{ route('booking.update-card', $booking->card_update_token) }}</a>
                            </p>
                            @endif
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:14px 24px;background:#f9fafb;color:#6b7280;font-size:12px;">
                            Booking reference: #{{ $booking->id }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
