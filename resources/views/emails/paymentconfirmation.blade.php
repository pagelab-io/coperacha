@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Confirmación de pago</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 45px;padding-top:10px;"> Hola FirstName </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                <b>¡Tu pago está confirmado!</b> Muchas gracias por haber participado en esta <a href="#" style='color:#FF5000;text-decoration:none;font-weight: bold'>coperacha</a>. El pago que hiciste, ahora ya está en la alcancía.
                Si quieres ir de nuevo a la alcancía <a href="#" style='color:#FF5000;text-decoration:none;font-weight: bold'>haz click aquí</a>.
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
            <img width="300" src="/images/emails/logo2.png"/>
        </td>
    </tr>
@endsection