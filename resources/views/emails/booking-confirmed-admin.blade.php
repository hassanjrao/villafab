<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking (Admin)</title>
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
                            New Booking Confirmed – Villa Fabulosa
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 24px;font-size:14px;line-height:1.6;">

                            <p style="margin:0 0 12px;">Hello Admin,</p>
                            <p style="margin:0 0 16px;">A new booking has been confirmed for Villa Fabulosa. Below are the full details:</p>

                            {{-- Booking Timestamp & ID --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #dbe7ef;border-radius:8px;">
                                <tr>
                                    <td style="padding:12px 14px;background:#f8fcff;">
                                        <strong>📅 Date Booked:</strong> {{ $booking->created_at->format('l, F j, Y \a\t g:i A') }}<br>
                                        <strong>Booking ID:</strong> #{{ $booking->id }}
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

                            {{-- Booking Details --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        🏠 Booking Details</td>
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
                                    <td style="padding:8px 0;"><strong>Number of Guests</strong></td>
                                    <td style="padding:8px 0;" align="right">{{ $booking->guests }}</td>
                                </tr>
                            </table>

                            {{-- Pricing Breakdown --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        💲 Pricing Breakdown</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Nightly Rate Total</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->subtotal - $booking->extra_guest_charges, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Extra Guest Charges</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->extra_guest_charges, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Cleaning Fee</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->cleaning_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Taxes</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->tax_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;font-size:16px;font-weight:700;">💰 Total Booking Amount</td>
                                    <td style="padding:10px 0;font-size:16px;font-weight:700;" align="right">
                                        ${{ number_format($booking->total, 2) }}</td>
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
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Payment Option Selected</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->payment_type === 'deferred' ? '50% Deposit' : 'Full Payment' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount Paid{{ $booking->payment_type === 'deferred' ? ' Now' : '' }}</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->amount_paid, 2) }}</td>
                                </tr>
                                @if($booking->payment_type === 'deferred')
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Remaining Balance</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->balance_due, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;"><strong>Balance Due Date</strong></td>
                                    <td style="padding:8px 0;" align="right">
                                        {{ $booking->balance_charge_date ? $booking->balance_charge_date->format('l, F j, Y') : '-' }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td style="padding:8px 0;"><strong>Balance Due</strong></td>
                                    <td style="padding:8px 0;" align="right">$0.00</td>
                                </tr>
                                @endif
                            </table>

                            {{-- Additional Notes --}}
                            @if($booking->notes)
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        📝 Additional Notes</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">{{ $booking->notes }}</td>
                                </tr>
                            </table>
                            @endif

                            {{-- Action Items --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        ⚠️ Action Items</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;">
                                        ✅ Review booking details<br>
                                        ✅ Confirm guest communication (if needed)<br>
                                        ✅ Schedule cleaning and preparation
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
