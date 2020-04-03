@component('mail::message')
# Welcome

The body of your message. your new password is {{ $password }}

@component('mail::button', ['url' => $url ."/api/password/reset/". $token . "?email=" . $email])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
