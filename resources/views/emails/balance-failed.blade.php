<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Issue</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellpadding="0" cellspacing="0"
                    style="max-width:640px;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="padding:24px 28px;background:#b42318;color:#ffffff;font-size:22px;font-weight:700;">
                            Action Required: Issue Processing Your Payment
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 28px;font-size:15px;line-height:1.6;">

                            <p style="margin:0 0 12px;">Hello {{ $booking->name }},</p>
                            <p style="margin:0 0 16px;">We attempted to process your scheduled final payment for your reservation at Villa Fabulosa, but unfortunately, the transaction did not go through.</p>
                            <p style="margin:0 0 16px;">No worries—this can happen for simple reasons like card limits, expiration dates, or bank security checks.</p>

                            {{-- Reservation Details --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
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
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
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
                                        {{ $cardDetails['brand'] ?? 'Card' }} ending in {{ $cardDetails['last4'] ?? '****' }}
                                    </td>
                                </tr>
                                @endif
                            </table>

                            {{-- What You Need to Do --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #dbe7ef;border-radius:8px;background:#f8fcff;">
                                <tr>
                                    <td style="padding:16px;">
                                        <strong style="font-size:16px;">🔧 What You Need to Do</strong><br><br>
                                        To secure your reservation, please take one of the following steps as soon as possible:<br><br>
                                        <strong>1. Update your payment method</strong><br>
                                        @if($booking->card_update_token)
                                        👉 <a href="{{ route('booking.update-card', $booking->card_update_token) }}"
                                            style="color:#0b6aa2;font-weight:600;">Update Payment Method</a><br><br>
                                        @endif
                                        <strong>2. Contact your bank/card provider</strong><br>
                                        Sometimes transactions are declined for security reasons.
                                    </td>
                                </tr>
                            </table>

                            {{-- Important Warning --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #fca5a5;border-radius:8px;background:#fef2f2;">
                                <tr>
                                    <td style="padding:14px 16px;">
                                        <strong>⚠️ Important</strong><br><br>
                                        We will automatically attempt to process your payment again within the next <strong>24 hours</strong>.<br><br>
                                        To avoid any disruption or cancellation of your reservation, please ensure your payment method is up to date before the next attempt, otherwise your reservation will be canceled, and you will receive no refund.
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:18px 0 12px;"><strong>Need Help?</strong></p>
                            <p style="margin:0 0 16px;">If you have any questions or need assistance, feel free to contact us—we’re here to help. Please call {{ config('app.support_phone') }} or send an email to {{ config('mail.from.address') }}</p>
                            <p style="margin:0 0 0;">We look forward to hosting you at Villa Fabulosa!</p>
                            <p style="margin:12px 0 0;">Warm regards,<br><strong>Villa Fabulosa Team</strong></p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:14px 28px;background:#f9fafb;color:#6b7280;font-size:12px;">
                            Booking reference: #{{ $booking->id }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
