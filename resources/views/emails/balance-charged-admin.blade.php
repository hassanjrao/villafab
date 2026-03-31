<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Charged (Admin)</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="700" cellpadding="0" cellspacing="0"
                    style="max-width:700px;background:#ffffff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="padding:20px 24px;background:#1f2937;color:#ffffff;font-size:20px;font-weight:700;">
                            Balance Charged Successfully</td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;font-size:14px;line-height:1.6;">
                            <p style="margin:0 0 12px;">The automatic balance charge for booking #{{ $booking->id }}
                                was successful.</p>
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
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        Guest Details</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Name</strong>
                                    </td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;"><strong>Email</strong>
                                    </td>
                                    <td style="padding:8px 0;border-bottom:1px solid #f0f2f5;" align="right">
                                        {{ $booking->email ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;"><strong>Phone</strong></td>
                                    <td style="padding:8px 0;" align="right">{{ $booking->phone ?: '-' }}</td>
                                </tr>
                            </table>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border-collapse:collapse;">
                                <tr>
                                    <td colspan="2"
                                        style="padding:8px 0;font-size:16px;font-weight:700;border-bottom:2px solid #e5e7eb;">
                                        Reservation Details</td>
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
                                    <td style="padding:8px 0;"><strong>Total</strong></td>
                                    <td style="padding:8px 0;" align="right">${{ number_format($booking->total, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
