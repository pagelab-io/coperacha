@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Meta alcanzada</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">Hola Firstname</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Wow… <b>¡muchas felicidades!</b> La meta de tu alcancía ha sido alcanzada.
            </p>
            <p>
                Seguro te estarás preguntando qué sigue ahora. Pues ahora viene la parte divertida: tienes que decidir a quién le transferirás el dinero de la alcancía.
            </p>
            <p>
                Para hacerlo has click aquí.
            </p>
            <p>
                <a href="#">link de tranferencía de la alcancía (deberia estar logueado)</a>
            </p>
            <p>Si tienes dudas por favor <a href="#">has click aquí. (link de contacto quizas)</a></p>
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