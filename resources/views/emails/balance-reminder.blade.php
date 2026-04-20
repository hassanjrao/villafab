<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Payment Reminder</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellpadding="0" cellspacing="0"
                    style="max-width:640px;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="padding:24px 28px;background:#0b6aa2;color:#ffffff;font-size:22px;font-weight:700;">
                            Upcoming Payment Reminder – Villa Fabulosa
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 28px;font-size:15px;line-height:1.6;">

                            <p style="margin:0 0 12px;">Hello {{ $booking->name }},</p>
                            <p style="margin:0 0 16px;">We hope you're looking forward to your stay at Villa Fabulosa!</p>
                            <p style="margin:0 0 16px;">This is a friendly reminder that your second and final payment for your reservation will be automatically processed in <strong>{{ $reminderDays }} {{ $reminderDays === 1 ? 'day' : 'days' }}</strong>.</p>

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

                            {{-- Initial Payment --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        💳 Initial Payment</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount Paid</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->amount_paid, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;"><strong>Charge Date</strong></td>
                                    <td style="padding:8px 0;" align="right">
                                        {{ $booking->created_at ? $booking->created_at->format('l, F j, Y') : '-' }}</td>
                                </tr>
                            </table>

                            {{-- Upcoming Payment Details --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        💰 Upcoming Payment Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount to be Charged</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->balance_due, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Scheduled Charge Date</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->balance_charge_date ? $booking->balance_charge_date->format('l, F j, Y') : '-' }}</td>
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

                            {{-- Important Reminder --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #fde68a;border-radius:8px;background:#fffbeb;">
                                <tr>
                                    <td style="padding:14px 16px;">
                                        <strong>⚠️ Important Reminder</strong><br><br>
                                        To ensure a smooth and uninterrupted reservation:<br>
                                        ✅ Please confirm that your payment method is still valid<br>
                                        ✅ Make sure there are sufficient funds/credit available<br>
                                        ✅ If your card has changed or needs to be updated, please update it before the charge date
                                    </td>
                                </tr>
                            </table>

                            {{-- Update Payment Link --}}
                            @if($booking->card_update_token)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;">
                                <tr>
                                    <td style="padding:10px 0;font-size:16px;font-weight:700;">
                                        🔄 Need to Update Your Payment Method?</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 0 12px;">You can securely update your payment details here:</td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('booking.update-card', $booking->card_update_token) }}"
                                            style="display:inline-block;padding:14px 28px;background:#0b6aa2;color:#ffffff;font-size:15px;font-weight:600;text-decoration:none;border-radius:8px;">
                                            Update Payment Method
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <p style="margin:0 0 16px;">If there are any issues processing the payment, we will notify you right away to avoid any disruption to your reservation.</p>

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
