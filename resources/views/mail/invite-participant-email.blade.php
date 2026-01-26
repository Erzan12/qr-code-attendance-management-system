<x-mail::message>

Hello, {{$participant['name']}}<br>

You're invited to the {{$event['title']}} event <br>

Date: {{$event['date']}}
Time Start: {{$event['time_start']}}

For more information kindly check the event in the system.
<a href="{{config('app.url')}}">{{config('app.url')}}</a>

Thank you.

</x-mail::message>
