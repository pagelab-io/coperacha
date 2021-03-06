@extends('emails.master')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:35px;">¡Bienvenido/a a Coperacha, {{$person->name}}!</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                Primero que nada, queremos agradecerte por unirte a nuestra comunidad, esperamos acompañarte en muchas aventuras.
            </p>
            <p>
                <a href="{{route('pages.index')}}" style='color:#FF5000;text-decoration:none; font-weight: bold'>Coperacha</a>, nace de la necesidad de hacer que el juntar el dinero de un grupo de personas sea mucho más fácil y divertido.
            </p>
            <p>
                Estaremos en contacto contigo a través de emails para mantenerte informado de las novedades y algunos tips que pueden ser de utilidad para tus alcancías.
            </p>
            <p>
                Por el momento nos despedimos, pero es un gusto tenerte con nosotros.
            </p>
            <p>
                Saludos.
            </p>
        </td>
    </tr>
@endsection