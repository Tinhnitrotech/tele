<p>Dear {{$user_name}},
    {{ trans('staff_register_mail.content') }}<br>
    <strong>{{ trans('staff_register_mail.email') }}</strong> : {{ $email }} <br>
    <strong>{{ trans('staff_register_mail.password') }} </strong>: {{ $password }}
</p>
