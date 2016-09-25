@extends('emails.master')

@section('title')
<title>Confirmación de pago</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 35px;padding-top:10px;"> Hola {{$payer->name}} </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                <b>¡Tu pago está confirmado!</b> Muchas gracias por haber participado en esta <a style="color:#FF5000;text-decoration:none;font-weight: bold" href={{url('/moneybox/detail/'.$moneybox->url)}}>coperacha</a>. El pago que hiciste, ahora ya está en la alcancía.
                Si quieres ir de nuevo a la alcancía <a style='color:#FF5000;text-decoration:none;font-weight: bold' href={{url('/moneybox/detail/'.$moneybox->url)}}>haz click aquí</a>.
            </p>
            <p>
                Saludos.
            </p>
        </td>
    </tr>
@endsection