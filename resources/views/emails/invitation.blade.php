@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => url('/invitation/'.$data['invitation']['id'])])
Try it now
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
