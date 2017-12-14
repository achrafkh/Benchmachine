@component('mail::message')
# Introduction

Thank you for using our app

@component('mail::button', ['url' => url('/')])
Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
