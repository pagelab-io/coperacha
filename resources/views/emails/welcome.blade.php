@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Bienvenido</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">¡Bienvenida/o a Coperacha, Emmanuel!</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Primero que nada, queremos agradecerte por unirte a nuestra comunidad, esperamos acompañarte en muchas aventuras.
            </p>
            <p>
                <a href="#" style='color:#FF5000;text-decoration:none; font-weight: bold'>Coperacha</a>, nace de la necesidad de hacer que el juntar el dinero de un grupo de personas sea mucho más fácil y divertido.
            </p>
            <p>
                Estaremos en contacto contigo a través de emails para mantenerte informado de las novedades y algunos tips que pueden ser de utilidad para tus alcancías.
            </p>
            <p>
                Por el momento nos despedimos, pero es un gusto tenerte con nosotros.
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