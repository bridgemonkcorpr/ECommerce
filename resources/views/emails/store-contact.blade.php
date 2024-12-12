<x-mail::message>
<p>
    {{ __('You have a new contact form submission!') }}
</p>
<p>
    {{ __('Here are the details:') }}
</p>
<ul>
    <li>
        <strong>{{ __('Name:') }}</strong> {{ $name }}
    </li>
    <li>
        <strong>{{ __('Email:') }}</strong> {{ $email }}
    </li>
    <li>
        <strong>{{ __('Phone:') }}</strong> {{ $phone }}
    </li>
</ul>
<p>
    {{ __('Message:') }}
</p>
<x-mail::panel>
    {{ $message }}
</x-mail::panel>

<br>
{{ config('app.name') }}
</x-mail::message>
