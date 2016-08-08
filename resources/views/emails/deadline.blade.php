@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Vencimiento de la alcancía</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 45px;padding-top:10px;"> Hola FirstName </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Pronto se vencerá tu alcancía y por lo que vemos estás muy cerca de la meta.
            </p>
            <p>
                <b>¡Ánimo!</b> Con este último empujón seguro la alcanzas.
            </p>
            <p>
                Realiza tu coperacha en:
            </p>
            <p>
                <a href="" style='color:#FF5000;text-decoration:none;'>link de la alcancía</a>
            </p>
            <p>
                Y no olvides invitar a nuevos participantes, comparte este link para que se unan a la alcancía:
            </p>
            <p>
                <a href="" style='color:#FF5000;text-decoration:none;'>link de la alcancía</a>
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