<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Paid</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellpadding="0" cellspacing="0"
                    style="max-width:640px;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="padding:24px 28px;background:#0b6aa2;color:#ffffff;font-size:22px;font-weight:700;">
                            Your Balance Has Been Paid</td>
                    </tr>
                    <tr>
                        <td style="padding:24px 28px;font-size:15px;line-height:1.6;">
                            <p style="margin:0 0 12px;">Dear {{ $booking->name }},</p>
                            <p style="margin:0 0 16px;">Great news. Your remaining balance payment for your Villa
                                Fabulosa reservation has been successfully processed.</p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin:0 0 16px;border:1px solid #dbe7ef;border-radius:8px;">
                                <tr>
                                    <td style="padding:12px 14px;background:#f8fcff;"><strong>Amount Charged:</strong>
                                        ${{ number_format($booking->total, 2) }}<br><strong>Status:</strong> Fully Paid
                                    </td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;margin:0 0 16px;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:10px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        Reservation Summary</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Check-in</strong>
                                    </td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->checkin ? $booking->checkin->format('l, F j, Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;">
                                        <strong>Check-out</strong></td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->checkout ? $booking->checkout->format('l, F j, Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Guests</strong>
                                    </td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->guests }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;"><strong>Total Paid</strong></td>
                                    <td style="padding:8px 0;" align="right">${{ number_format($booking->total, 2) }}
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 18px;">We look forward to welcoming you to Villa Fabulosa.</p>
                            <p style="margin:0;">Warm regards,<br><strong>Villa Fabulosa Team</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 28px;background:#f9fafb;color:#6b7280;font-size:12px;">Booking
                            reference: #{{ $booking->id }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
