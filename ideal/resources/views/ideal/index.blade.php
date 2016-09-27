@extends('ideal/template')
@section('content')
<div class='header' >  
    <nav class="textcontainer_l">
        
        <h2>Лучшие люди Интернета</h2>
        <br>
    </nav>
    <nav class="text_r">
        
        <a href="http://ideal/enter">Войти</a><br>
        <a href="http://ideal/registration">Зарегистрироваться</a>
        
    </nav>
</div>
<br>
<div class="people" id="people">
    
    <br>
    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
    <div id="people2" class="people2">

    </div>
</div>

@stop