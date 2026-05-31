<x-mail::message>
# Hi, {{ $name }}

We're excited to have you on board! Below are your login credentials:

- **Email:** {{ $email }}
- **Password:** {{ $password }}

<x-mail::button :url="route('login')">
Login Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
