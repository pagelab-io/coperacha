@extends('emails.master')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:35px;">Solicitud de Retiro</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <h3 style="margin-bottom: 1px;">Datos de la alcancía:</h3>
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
            <h3 style="margin-bottom: 1px;">Datos del usuario:</h3>
            <table style="width: 100%">
                <tr>
                    <td style="width: 200px"><strong>Nombre del beneficiario</strong></td>
                    <td>{{$order->name}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Correo electrónico</strong></td>
                    <td>{{$order->email}}</td>
                </tr>
                <tr>
                    <td style="width: 200px"><strong>Banco</strong></td>
                    <td>{{$order->bank_name}}</td>
                </tr>
                @if($order->account!="")
                    <tr>
                        <td style="width: 200px"><strong>Tarjeta destino</strong></td>
                        <td>{{$order->account}}</td>
                    </tr>
                @endif
                @if($order->clabe!="")
                    <tr>
                        <td style="width: 200px"><strong>Clabe interbancaria</strong></td>
                        <td>{{$order->clabe}}</td>
                    </tr>
                @endif
                @if($order->cellphone!="")
                    <tr>
                        <td style="width: 200px"><strong>Número celular</strong></td>
                        <td>{{"+(".$order->areacode.") ".$order->cellphone}}</td>
                    </tr>
                @endif
            </table>
            <hr>
            <p>Saludos.</p>
        </td>
    </tr>
@endsection