@extends('emails.master')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 35px;padding-top:10px;"> Hola {{$payer->name}} </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                ¡Tu pago está confirmado! Muchas gracias por haber participado en esta <a style="color:#FF5000;text-decoration:none;font-weight: bold" href={{url('/moneybox/detail/'.$moneybox->url)}}>coperacha</a>. El pago que hiciste, ahora ya está en la alcancía.
                Si quieres ir de nuevo a la alcancía <a style='color:#FF5000;text-decoration:none;font-weight: bold' href={{url('/moneybox/detail/'.$moneybox->url)}}>haz clic aquí</a>.
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <tr>
                <td>Alcancía</td>
                <td style="text-align: right">{{$moneybox->name}}</td>
            </tr>
            <tr>
                <td>Organizador</td>
                <td style="text-align: right">{{$creator->name." ".$creator->lastname}}</td>
            </tr>
            <tr>
                <td>Fecha</td>
                <td style="text-align: right">{{\Carbon\Carbon::today()->toFormattedDateString()}}</td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td style="text-align: right">$ {{number_format($payment->amount, 2)}}</td>
            </tr>
            <tr>
                <td>Comisión</td>
                <td style="text-align: right">$ {{number_format($payment->commission, 2)}}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td style="text-align: right; font-weight: bold">$ {{number_format(($payment->amount+$payment->commission), 2)}}</td>
            </tr>
        </td>
    </tr>
    <tr>
        <td>
            <br>
            <p>Saludos.</p>
        </td>
    </tr>
@endsection