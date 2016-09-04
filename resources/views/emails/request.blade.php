@extends('emails.master')
@section('title', 'Solicitud de Retiro')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">Solicitud de Retiro</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <h3>Datos de la alcancía:</h3>
            <table style="width: 100%">
                <tr>
                    <td style="width: 200px"><strong>Nombre</strong></td>
                    <td>{{$moneybox->name}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Cantidad</strong></td>
                    <td>{{$moneybox->collected_amount}}</td>
                </tr>
            </table>
            <hr>
            <h3>Datos del usuario:</h3>
            <table style="width: 100%">
                <tr>
                    <td style="width: 200px"><strong>Nombre del titular</strong></td>
                    <td>{{$order->name}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Banco</strong></td>
                    <td>{{$order->bank_name}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Clabe Interbancaria</strong></td>
                    <td>{{$order->clabe}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Número de cuenta</strong></td>
                    <td>{{$order->account}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Dirección del Banco</strong></td>
                    <td>{{$order->bank_address}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Comentarios</strong></td>
                    <td>{{$order->comments}}</td>
                </tr>
            </table>
            <hr>
            <p>Un administrador de coperacha se pondra en contacto contigo a la brevedad para dar seguimiento al retiro.</p>
            <p>Saludos,<br>Pepe</p>
        </td>
    </tr>
    <tr>
        <td COLSPAN=2 style="text-align: center;padding-bottom:20px;">
            <img width="300" src="{{asset('/images/emails/logo2.png')}}"/>
        </td>
    </tr>
@endsection