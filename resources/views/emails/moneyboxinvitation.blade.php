@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Invitación a alcancía</title>
@endsection

@section('body')
    <!-- nombre alcancia -->
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #FF5000;text-align: center;line-height: 30px;padding-top:45px;padding-bottom:15px;">
            << Nombre de la alcancía >>
        </td>
    </tr>
    <!-- nombre alcancia -->
    <tr>
        <td COLSPAN=2 align="center" height="1" style="font-size:1px; line-height:1px; background: #CCCCCC"></td>
    </tr>
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:10px;"> Hola FirstName </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Coperacha es una plataforma en línea que facilita la recaudación de dinero entre un grupo de personas.
            </p>
            <p>
                (XXX nombre del administrador de la alcancía) te invitó a que te unas a la alcancía (YYY nombre de la alcancía) la cual busca (WWW motivo)
            </p>
            <p>
                Encuentra todos los detalles en:
            </p>
            <p>
                <a href="#">enlace de la alcancía</a>
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