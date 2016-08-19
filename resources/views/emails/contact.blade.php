@extends('emails.master')

@section('title', 'Contacto')

@section('body')
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
