@component('mail::message')
# New contact for service

<ul>

    <li>  {{ $contact->email }}</li>
    <li>  {{ $contact->message }}</li>
    <li>  {{ $contact->type }}</li>
    <li>
        <pre> @php print_r($others) @endphp </pre>
    </li>

</ul>

{{--@component('mail::button', ['url' => ''])--}}
    {{--Button Text--}}
{{--@endcomponent--}}


{{--<pre> {{ $others }} </pre>--}}

Thanks,<br>

{{ config('app.name') }}
@endcomponent
