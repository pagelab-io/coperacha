@extends('emails.master')
@extends('emails.header')
@extends('emails.footer')

@section('title')
<title>Confirmación de transferencia</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:35px;">Felicidades Firstname</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                Te informamos que el monto total de tu alcancía ha sido transferido a la cuenta que nos indicaste.
            </p>
            <p>
                Muchas gracias por utilizar Coperacha y esperamos acompañarte en muchas aventuras más.
            </p>
            <p>
                ¿Tienes sugerencias para mejorar nuestro servicio? Por favor escríbenos a hola@coperacha.com.mx nos encantaría saber tú opinión.
            </p>
            <p>
                Saludos.
            </p>
        </td>
    </tr>
@endsection