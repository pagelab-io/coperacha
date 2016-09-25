@extends('emails.master')
@section('title', 'Recordatorio participación')

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Hola, observamos que tienes una invitación pendiente para
                participar en la alcancía llamada <strong>{{$moneybox->name}}</strong>
                creada por <strong>{{$moneybox->person->name}}</strong>, la cual busca
                <strong>{{$moneybox->description}}</strong>.
            </p>
            <p>
                Para poder participar entra al siguiente link:<strong><a href="{{asset('/moneybox/detail/'.$moneybox->url)}}" style='color:#FF5000;text-decoration:none;'>{{$moneybox->name}}</a></strong>
            </p>
            <p>Saludos.</p>
        </td>
    </tr>
@endsection