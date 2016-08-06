@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Recordatorio participación</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">Hola Firstname</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Hola, observamos que tienes una invitación pendiente para participar en la alcancía llamada (nombre de la alcancia) creada por (nombre del creador de la alcancía), la cual busca (motivo de la alcancía).
            </p>
            <p>
                Para poder participar entra al siguiente link:
            </p>
            <p>
                <a href="#">Enlace de la alcancía</a>
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