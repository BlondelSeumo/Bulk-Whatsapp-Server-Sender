@component('mail::message')

Dear {{ $data['name'] }},

{{ __('Thanks for useing ') }} <strong>{{ $data['plan_name'] }}</strong>. 
{{ __('Your subscription will ending soon the last due date is ') }} <strong>{{ $data['will_expire'] }}</strong>.
{{ __('Please renew your subscription') }}

@component('mail::table')
| {{ __('Description') }} | {{ __('Amount') }}  |
| :---------------------- | :------------------ |
@foreach ($data['contents'] ?? [] as $key => $content)
| {{$key}} | {{$content}} |
@endforeach

@endcomponent

@component('mail::button', ['url' => url($data['link']) ])
{{ __('Renew Subscription Now') }}
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent