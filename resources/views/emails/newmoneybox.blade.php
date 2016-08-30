@extends('emails.master')

@section('title')
<title>Nueva alcancía</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:45px;">Felicidades {{$person->name}}</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:10px;">
            <p>
                Se creó con éxito tu alcancía. Lo que es necesario hacer ahora, es invitar a los demás participantes y empezar a juntar el dinero.
            </p>
            <p>
                Comparte el <a href="{{url('/moneybox/detail/'.$moneybox->url)}}">link</a> o invítalos por correo o redes sociales, es muy fácil ya verás.
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
            <img width="300" src={{asset('/images/emails/logo2.png')}}/>
        </td>
    </tr>
@endsection