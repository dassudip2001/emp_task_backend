@component('mail::message')
# Hello!

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $url])

Reset Password

@endcomponent

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

Regards,<br>
{{ config('app.name') }}


_________________



<p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
    If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
    <span class="break-all" style=" word-break: break-all;">
        <a href="{{ $url }}" style=" width: 10%;">{{ $url }}</a>
    </span>
</p>

@endcomponent