@extends('emails.master')
@section('title', 'Solicitud de Transferencia')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">Solicitud de Dinero </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">

            <p>Solicitud de dinero de {{$moneybox->person->name}}</p>

            <table>
                <tr>
                    <td><strong>Nombre del titular</strong></td>
                    <td>{{$data->name}}</td>
                </tr>
                <tr>
                    <td><strong>Clabe Interbancaria</strong></td>
                    <td>{{$data->clabe}}</td>
                </tr>
                <tr>
                    <td><strong>Número de cuenta</strong></td>
                    <td>{{$data->account}}</td>
                </tr>
                <tr>
                    <td><strong>Banco</strong></td>
                    <td>{{$data->bankname}}</td>
                </tr>
                <tr>
                    <td><strong>Dirección del Banco</strong></td>
                    <td>{{$data->bankaddress}}</td>
                </tr>
                <tr>
                    <td><strong>Comentarios</strong></td>
                    <td>{{$data->text}}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Archivos</strong>
                        <ul>
                            <li>Datos.pdf</li>
                        </ul>
                    </td>
                </tr>
            </table>

            <p>Un administrador de coperacha se pondra en contacto contigo a la brevedad posible</p>

            <p>
                Saludos,
                <br>
                Pepe
            </p>
        </td>
    </tr>
    <tr>
        <td COLSPAN=2 style="text-align: center;padding-bottom:20px;">
            <img width="300" src="{{asset('/images/emails/logo2.png')}}"/>
        </td>
    </tr>
@endsection