@extends('emails.master')


@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 35px;padding-top:10px;"> Hola {{$creator->name}} </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                Tenemos muy buenas noticias para ti:
            </p>
            <p>
                ¡tu alcancía tiene una nueva coperacha!
            </p>
            <p>
                Lo que significa que ya están más cerca de la meta, muchas felicidades.
                Para ver los detalles de la coperacha, te invitamos a que entres a <a style='color:#FF5000;text-decoration:none;' href={{url('/moneybox/detail/'.$moneybox->url)}}>tu cuenta</a>.
            </p>
            <p>
                Saludos.
            </p>
        </td>
    </tr>
@endsection