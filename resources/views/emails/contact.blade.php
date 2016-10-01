@extends('emails.master')

@section('body')
    <tr>
        <td colspan="2"><h3>Mensaje de Contacto</h3></td>
    </tr>
    <tr>
        <td><strong>Nombre:</strong></td><td>{{$name}}</td>
    </tr>
    <tr>
        <td><strong>Email:</strong></td><td>{{$email}}</td>
    </tr>
    <tr>
        <td valign="top"><strong>Mensaje:</strong></td><td>{{$content}}</td>
    </tr>
@endsection
