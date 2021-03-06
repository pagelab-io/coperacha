@extends('emails.master')
@section('title', 'Invitación a alcancía')
@section('body')
    <tr>
        <td COLSPAN=2 align="center" height="1" style="font-size:1px; line-height:1px; background: #CCCCCC"></td>
    </tr>
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #FF5000;text-align: center;line-height: 30px;padding-top:35px;padding-bottom:15px;">
            <a href="{{asset('/moneybox/detail/'.$moneybox->url)}}" style='color:#FF5000;text-decoration:none;'>{{$moneybox->name}}</a>
        </td>
    </tr>
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>Coperacha es una plataforma en línea que facilita la recaudación de dinero entre un grupo de personas.</p>
            <p>
                {{$moneybox->person->name}} te invitó a que te unas a la alcancía <strong>{{$moneybox->name}} </strong>
                la cual busca <strong>{{$moneybox->description}}<strong>
            </p>
            <p>
                <span>Encuentra todos los detalles en:</span>
                <strong>
                    <a href="{{asset('/moneybox/detail/'.$moneybox->url)}}" style='color:#FF5000;text-decoration:none;'>{{$moneybox->name}}</a>
                </strong>
            </p>

            <p>Saludos.
        </td>
    </tr>
@endsection