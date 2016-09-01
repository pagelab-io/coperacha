@extends('emails.master')
@section('title', 'Recordatorio participación')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">Hola {{$invitation->email}}</td>
    </tr>
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Hola, observamos que tienes una invitación pendiente para
                participar en la alcancía llamada <strong>{{$moneybox->name}}</strong>
                creada por <strong>{{$moneybox->person->name}}</strong>, la cual busca {{$moneybox->description}}.
            </p>
            <p>Para poder participar entra al siguiente link:</p>
            <strong>
                <a href="{{asset('/moneybox/detail/'.$moneybox->url)}}" style='color:#FF5000;text-decoration:none;'>{{$moneybox->name}}</a>
            </strong>
            <p>Saludos,<br>Pepe</p>
        </td>
    </tr>
    <tr>
        <td COLSPAN=2 style="text-align: center;padding-bottom:20px;">
            <img width="300" src="{{asset('/images/emails/logo2.png')}}"/>
        </td>
    </tr>
@endsection