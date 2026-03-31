<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Reminder</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellpadding="0" cellspacing="0"
                    style="max-width:640px;background:#fff;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">
                    <tr>
                        <td style="padding:20px 24px;background:#0b6aa2;color:#fff;font-size:20px;font-weight:700;">
                            Upcoming Balance Charge</td>
                    </tr>
                    <tr>
                        <td style="padding:20px 24px;font-size:14px;line-height:1.6;">
                            <p>Dear {{ $booking->name }},</p>
                            <p>This is a reminder that your remaining balance will be charged automatically to your card
                                on file.</p>
                            <p><strong>Charge Date:</strong>
                                {{ $booking->balance_charge_date ? $booking->balance_charge_date->format('F j, Y') : '-' }}<br><strong>Balance
                                    Amount:</strong> ${{ number_format($booking->balance_due, 2) }}</p>
                            <p>Thank you,<br><strong>Villa Fabulosa Team</strong></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
