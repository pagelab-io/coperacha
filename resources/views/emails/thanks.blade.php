@extends('emails.master')
@section('title', 'Agradecimiento')

@section('body')
    <tr xmlns="http://www.w3.org/1999/html">
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 45px;padding-top:20px;"> Hola {{$user->person->name}}</td>
    </tr>
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Gracias por participar en mi alcancía <strong>{{$moneybox->name}}</strong>,
                pronto estare en contacto contigo.
            </p>

            <br>
            <p>Saludos, {{$owner->username}}.</p>
        </td>
    </tr>
@endsection