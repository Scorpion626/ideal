@extends('ideal/template')
@section('content')
   <div class="textcontainer_l2">
           <a href="http://ideal/">На главную</a>
   </div>
   <div class="text_r">

           <a href="http://ideal/enter">Войти</a><br>
   </div>
<div class="centerReg">
    <h1>Регистрация</h1><br>
    <h4 class="error">@if(isset($msg)){{$msg}}@endif</h4>
    <div class="leftContainer">
        <form action="registration" id="regform" method="post" enctype="multipart/form-data">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <label>Логин</label><br>
            <input type="text" name="login">
            <br>
            <label class="error">{{$errors->first('login')}}</label>
            <br>
            <label>Пароль</label><br>
            <div id='passField'>
                <input type="password" id="password" name="password"></div>&nbsp;&nbsp;
            <input type="checkbox" id='check'> &nbsp;Показать пароль<br>
            <label class="error">{{$errors->first('password')}}</label><br>
            
            <label>Подтвердите пароль</label><br>
              <div id='passFieldCon'>
                  <input type="password" id='password_conf' name="password_confirmation"></div>&nbsp;&nbsp;
              <input  type="checkbox" id='checkConf'>  &nbsp;Показать пароль<br>
            <br>
            <div class="file-upload">
                <label>
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg,imgage/gif">
                    <span>Выберите файл</span>
                </label>
            </div>
             
            <input type="text" id="filename" class="filename" disabled="">
            <br>
            <label class="error" id="errorFoto">
            @if(isset($errorFoto))
           
                {!!$errorFoto!!}
           
            @endif
            </label><br>
            <label>Дата рождения</label>
            <br>
            <input type="date" name="date">
            <br>
            <label class="error">{{$errors->first('date')}}</label><br>
            <select name='sex'>
                <option selected value="0">мужской</option>
                <option value="1">женский</option>
            </select>
            <br><br>
            <input type="submit" id="submit" name="submit" value="Подтвердить">
        </form>
    </div>
</div>
@stop