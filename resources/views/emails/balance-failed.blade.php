<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Failed</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellpadding="0" cellspacing="0"
                    style="max-width:640px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="padding:20px 24px;background:#b42318;color:#fff;font-size:20px;font-weight:700;">
                            Action Required: Payment Failed</td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;font-size:14px;line-height:1.6;">
                            <p>Dear {{ $booking->name }},</p>
                            <p>We were unable to process your remaining balance payment.</p>
                            <p><strong>Amount Due:</strong>
                                ${{ number_format($booking->balance_due, 2) }}<br><strong>Pay By:</strong>
                                {{ $booking->balance_failure_notified_at ? $booking->balance_failure_notified_at->copy()->addDays(2)->format('F j, Y') : 'Within 2 days' }}
                            </p>
                            <p>If payment is not received within 2 days, your reservation will be cancelled.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
