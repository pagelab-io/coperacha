@extends('emails.master')
@include('emails.header')


@section('title')
    <title>Contacto</title>
@endsection

@section('body')
    <tr>
        <td>Nombre:</td><td>{{$name}}</td>
        <td>Email:</td><td>{{$email}}</td>
        <td>Mensaje:</td><td>{{$content}}</td>
    </tr>
@endsection

@include('emails.footer')