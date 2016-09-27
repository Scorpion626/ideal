@extends('ideal/template')
@section('content')
    <nav class="textcontainer_l2">
        <a href="http://ideal/">На главную</a>
    </nav>
<div class="centerReg">
    <h1>Вход</h1>
    <div class="leftContainer">
        <form action="enter" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if(isset($errorEnt))
            <div class="error">
            <h4 border='1px'>{{$errorEnt}}</h2>
            </div>
            @endif
            <label>Логин:</label><br>
            <input type="text" name="login" autocomplete="off">&nbsp;&nbsp;
             {{$errors->first('login')}}<br>
            <label>Пароль:</label><br>
            <input type="password" name="password"autocomplete="off">&nbsp;&nbsp;
            {{$errors->first('password')}}<br><br>
            <input type='text' disabled class="captcha" size='6' value="{{$captcha}}" ><br><br>
            <input type="hidden" name="captcha_confirmation" value="{{$captcha}}">
            <label>Введите код с картинки</label>
            <br>
            <input type='text' size='10' name='captcha'>&nbsp;&nbsp;
            {{$errors->first('captcha')}}&nbsp;
            {{$errors->first('captcha_confirmation')}}<br><br>
            <input type='submit' name='submit'>
        </form>
    </div>
</div>
@stop