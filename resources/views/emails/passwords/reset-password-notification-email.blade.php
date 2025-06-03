@component('mail::message')

<style>
.heading1 {
    text-align: center;
    font-size:25px ;
}
.heading2{
    text-align: center;
}
</style>
<div>
<h1 id="identifier" class="heading1">
   Your password was changed!
</h1>

<h2 class="heading2" id="identifier"><a href="mailto:{{ $email }}" >{{ $email }}</a></h2>
</div>
<br>

___


The password for your {{ config('app.name') }} account <a href="mailto:{{ $email }}" style=" width: 10%;">{{ $email }}</a> was changed successfully. If you did not changed it, you should contact the administrator.

Regards,<br>
{{ config('app.name') }}
@endcomponent