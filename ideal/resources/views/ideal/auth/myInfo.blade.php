@extends('ideal/auth/template')
@section('content')
    <nav class="leftContainer_l2">
        <br>
        <a href="http://ideal/main" class="header_r">&nbsp;&nbsp;На главную</a><br>
   </nav>

<nav class="userInfo">
    <br>
    <img src="{{$foto}}" class="foto"> &nbsp;
    <nav class="login"><h3>{{session('login')}} &nbsp;&nbsp Ваша карма: {{$karma}}</h3>
        
    </nav>
   
    <div class="login">
    <a href='http://ideal/change'>Изменить информацию о себе</a>
    
    </div>
    <h3>История</h3>
     <div id="story">
        @if($story != NULL)
                @foreach ($story as $stor)
                @if($stor['Karma_change'] == '+')
                    <div class="plusStory">
                @else
                    <div class="minusStory">
                @endif  
                    <label> {{$stor['date']}} </label>&nbsp;
                    <a href='http://ideal/userInfo?user_id={{$stor['id_userFrom']}}'>{{$stor['loginStory']}}</a>&nbsp;
                    <label>{{$stor['sex']}}</label>&nbsp;
                    <label>{{$stor['Karma_change']}}</label>
                </div><br>
            @endforeach
        @else
            <h4 class='emptyKarma'>Извините, но вашу карму никто не изменял</h4>
        @endif
    </div>
    <h3>Комментарии</h3>
     <div class="comment" id="comments">
                @if($comments != NULL)
                    @foreach($comments as $com)
                    <div>
                        <pre class="commentVies">{{$com->comment}}</pre>
                        <label>{{$com->sex}}</label>
                         <a href='http://ideal/userInfo?user_id={{$com->id_user}}'>{{$com->login}}</a>&nbsp;
                         <label>{{$com->date}}</label>
                    </div>
                    @endforeach
                @else
                    <h4 class="emptyKarma">Эту страницу ещё никто не комментировал</h4>
                @endif
                <form method="POST" action='http://ideal/userInfo?user_id={{session('user_id')}}'>
                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                    <textarea name="comment" id="textCom" placeholder="Введите ваш комментарий"></textarea><br>
                    <input type="submit" name="add" value="добавить">
                </form>
            </div>
</nav>
@stop