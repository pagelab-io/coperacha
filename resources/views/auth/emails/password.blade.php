@extends('auth.emails.master')

@section('title')
<title>Recuperación de contraseña</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:35px;"> Hola {{$user->person->name}} </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                ¡Es horrible cuando no recuerdas tu contraseña! No te preocupes, estamos aquí para ayudarte.
            </p>
            <p>
                Por favor, sigue las instrucciones que encontrarás en este link:
            </p>
            <p>
                <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">
                    {{ $link }}
                </a>
            </p>
            <p>
                Si no realizaste esta solicitud, es posible que otro usuario haya ingresado tu correo electrónico por equivocación y tu cuenta todavía esté segura. Si crees que alguien ha accedido a tu cuenta sin autorización, te recomendamos cambiar tu contraseña inmediatamente visitando nuestra página.
            </p>
            <p>
                Saludos,
                <br>
                Pepe
            </p>
        </td>
    </tr>
    <tr>
        <td COLSPAN=2 style="text-align: center;padding-bottom:20px;">
            <img width="300" src={{asset('/images/emails/logo2.png')}}/>
        </td>
    </tr>
@endsection
