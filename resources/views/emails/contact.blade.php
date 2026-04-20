@component('mail::message')
# New Contact Message — Villa Fabulosa

You have received a new message through the Villa Fabulosa website contact form.

---

**Name:** {{ $data['fname'] }} {{ $data['lname'] }}

**Email:** {{ $data['email'] }}

**Phone:** {{ $data['phone_number'] }}

@if(!empty($data['reason']))
**How they heard about us:** {{ $data['reason'] }}
@endif

---

**Message:**

{{ $data['message'] }}

---

@component('mail::button', ['url' => 'mailto:' . $data['email'], 'color' => 'primary'])
Reply to {{ $data['fname'] }}
@endcomponent

Need Help?

If you have any questions or need assistance, feel free to contact us—we’re here to help. Please call {{ config('app.support_phone') }} or send an email to {{ config('mail.from.address') }}

We look forward to hosting you at Villa Fabulosa!

Warm regards,
Villa Fabulosa Team
@endcomponent
