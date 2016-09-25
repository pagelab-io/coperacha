@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Recuperación de contraseña</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:35px;"> Hola FirstName </td>
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
                <a href="#">enlace de recuperación de contraseña</a>
            </p>
            <p>
                Si no realizaste esta solicitud, es posible que otro usuario haya ingresado tu correo electrónico por equivocación y tu cuenta todavía esté segura. Si crees que alguien ha accedido a tu cuenta sin autorización, te recomendamos cambiar tu contraseña inmediatamente visitando nuestra página.
            </p>
            <p>
                Saludos.
            </p>
        </td>
    </tr>
@endsection