@extends('emails.master')

@section('title')
<title>Meta alcanzada</title>
@endsection

@section('body')
    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 30px;color: #51B7CD;text-align: center;line-height: 30px;padding-top:35px;">Hola {{$creator->name}}</td>
    </tr>

    <tr>
        <td COLSPAN=2 style="font-family: Arial;font-size: 16px;color: #666666;text-align: justify;line-height: 28px; padding-top:20px;">
            <p>
                Wow… <b>¡muchas felicidades!</b> La meta de tu alcancía ha sido alcanzada.
            </p>
            <p>
                Seguro te estarás preguntando qué sigue ahora. Pues ahora viene la parte divertida: tienes que decidir a quién le transferirás el dinero de la alcancía.
            </p>
            <p>
                Para hacerlo has click <a style='color:#FF5000;text-decoration:none;' href={{url('/moneybox/detail/'.$moneybox->url)}}>aqui</a>.
            </p>
            <p>Si tienes dudas por favor has click <a style='color:#FF5000;text-decoration:none;' href={{route('pages.contact')}}>aquí.</a></p>
            <p>
                Saludos.
            </p>
        </td>
    </tr>
@endsection