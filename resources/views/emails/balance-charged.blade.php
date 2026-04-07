<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Received</title>
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
                            Payment Received – Reservation Fully Confirmed
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px 28px;font-size:15px;line-height:1.6;">

                            <p style="margin:0 0 12px;">Hello {{ $booking->name }},</p>
                            <p style="margin:0 0 16px;">Great news—your final payment has been successfully processed, and your reservation at Villa Fabulosa is now <strong>fully confirmed</strong>.</p>
                            <p style="margin:0 0 16px;">We're excited to host you!</p>

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

                            {{-- Payment Summary --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        💳 Payment Summary</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Payment Type</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">Final Payment (Second Installment)</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount Charged</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($chargedAmount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Date Processed</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ now()->format('l, F j, Y') }}</td>
                                </tr>
                                @if(!empty($cardDetails['brand']) || !empty($cardDetails['last4']))
                                <tr>
                                    <td style="padding:8px 0;" colspan="2">
                                        <strong>Payment Method:</strong><br>
                                        {{ $cardDetails['brand'] ?? 'Card' }} ending in {{ $cardDetails['last4'] ?? '****' }}
                                    </td>
                                </tr>
                                @endif
                            </table>

                            {{-- Total Booking Summary --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        💰 Total Booking Summary</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Total Reservation Amount</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($booking->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount Previously Paid</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($previouslyPaid, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Amount Paid Today</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        ${{ number_format($chargedAmount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px 0;font-size:16px;font-weight:700;">Remaining Balance</td>
                                    <td style="padding:10px 0;font-size:16px;font-weight:700;color:#065f46;" align="right">$0.00 (Paid in Full)</td>
                                </tr>
                            </table>

                            {{-- What Happens Next --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #d1fae5;border-radius:8px;background:#ecfdf5;">
                                <tr>
                                    <td style="padding:14px 16px;">
                                        <strong>✅ What Happens Next</strong><br><br>
                                        ✅ Your reservation is now 100% confirmed<br>
                                        ✅ You will receive check-in instructions closer to your arrival date<br>
                                        ✅ Our team will ensure everything is perfectly prepared for your stay
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px;">If you have any questions or need assistance before your stay, feel free to reach out anytime at <strong>619-578-4013</strong>.</p>

                            <p style="margin:0 0 0;">We look forward to welcoming you to Villa Fabulosa!</p>
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
