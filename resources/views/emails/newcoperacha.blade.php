@extends('emails.master')

@section('title')
<title>Nueva coperacha</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 45px;padding-top:10px;"> Hola {{$creator->name}} </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Tenemos muy buenas noticias para ti:
            </p>
            <p>
                <b>¡tu alcancía tiene una nueva coperacha!</b>
            </p>
            <p>
                Lo que significa que ya están más cerca de la meta, muchas felicidades.
                Para ver los detalles de la coperacha, te invitamos a que entres a <a style='color:#FF5000;text-decoration:none;' href={{url('/moneybox/detail/'.$moneybox->url)}}>tu cuenta</a>.
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