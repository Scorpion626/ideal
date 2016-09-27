@extends('ideal/auth/template')
@section('content')
<nav class="leftContainer_l2">
        <br>
        <a href="http://ideal/main">На главную</a><br>
   </nav>
<nav >
    <h3 align='center'>Мой профиль</h3>
    <br>
    <nav class="change">
        <form action="change" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label style="font-weight: bold">Мой логин:</label>&nbsp;
        <label> &nbsp;{{session('login')}}</label><br>
        <label style="font-weight: bold">Аватар</label>
        <div class="file-upload">
                <label>
                    <input type="file" name="foto" id="foto" accept="image/jpeg,image/png,image/jpg,imgage/gif">
                    <span>Выберите файл</span>
                </label>
         </div>
        <nav class="error">
            <label id="errorFoto">
                @if(isset($fotoErr))
                {!! $fotoErr !!}
            </label>
        @endif
         </nav>
        <input type="text" id="filename" class="filename" disabled="">
            <br>
        <label>Пол</label>
        <br>
        <select name="sex">
            <option selected value="{{$sex}}">{{$sexName}}</option>
            <option value="{{$unCheckSex}}">{{$unCheck}}</option>
        </select>
        <br>
        <br>
        <input type="submit" name="submit" id="submit" value="Подтвердить">
        </form>
    </nav>
</nav>
@stop