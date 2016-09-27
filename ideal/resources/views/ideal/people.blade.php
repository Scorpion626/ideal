@extends('ideal/template')
@section('content')
    @foreach($pop as $popular)
    <img src="{{$popular['foto']}}"><br>
    <a href="http://ideal/userInfo?user_id={{$popular['user_id']}}">{{$popular['login']}}</a>
    <br>
    @endforeach
@stop