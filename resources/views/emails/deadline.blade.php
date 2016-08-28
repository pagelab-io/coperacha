@extends('emails.master')
@section('title', 'Vencimiento de la alcancía')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 45px;padding-top:10px;"> Hola {{$name}} </td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Pronto se vencerá tu alcancía y por lo que vemos estás muy cerca de la meta.
            </p>
            <p>
                <b>¡Ánimo!</b> Con este último empujón seguro la alcanzas.
            </p>
            <p>
                Realiza tu coperacha en:
            </p>
            <p>
                <a href="{{asset($link)}}" style='color:#FF5000;text-decoration:none;'>{{$moneybox}}</a>
            </p>
            <p>
                Y no olvides invitar a nuevos participantes, comparte este link para que se unan a la alcancía:
            </p>
            <p>
                <a href="{{asset($link)}}" style='color:#FF5000;text-decoration:none;'>{{$moneybox}}</a>
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
            <img width="300" src="{{asset('/images/emails/logo2.png')}}"/>
        </td>
    </tr>
@endsection