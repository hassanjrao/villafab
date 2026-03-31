<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Failed Admin</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="700" cellpadding="0" cellspacing="0"
                    style="max-width:700px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="padding:20px 24px;background:#1f2937;color:#fff;font-size:20px;font-weight:700;">
                            Balance Charge Failed</td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;font-size:14px;line-height:1.6;">
                            <p>The automatic balance charge failed for booking #{{ $booking->id }}.</p>
                            <p><strong>Name:</strong> {{ $booking->name }}<br><strong>Email:</strong>
                                {{ $booking->email ?: '-' }}<br><strong>Balance Due:</strong>
                                ${{ number_format($booking->balance_due, 2) }}<br><strong>Notified At:</strong>
                                {{ $booking->balance_failure_notified_at ? $booking->balance_failure_notified_at->format('F j, Y g:i A') : now()->format('F j, Y g:i A') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
