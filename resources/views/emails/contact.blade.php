@extends('emails.master')

@section('title', 'Contacto')

@section('body')
    <tr>
        <td colspan="2"><h3>Mensaje de Contacto</h3></td>
    </tr>
    <tr>
        <td>Nombre:</td><td>{{$name}}</td>
    </tr>
    <tr>
        <td>Email:</td><td>{{$email}}</td>
    </tr>
    <tr>
        <td>Mensaje:</td><td>{{$content}}</td>
    </tr>
@endsection
