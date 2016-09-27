@extends('ideal/auth/template')
@section('content')
<div id="preloade">
        <nav class="leftContainer_l2">
            <br>
            <a class="header_r" href="http://ideal/main">На главную</a><br>
       </nav>
        <div class="userKarm">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            {!! $plus !!}
            <br>
            {!! $minus !!}
        </div>
    <nav class="userInfo">
        <br>
        <img src="{{$fotoUser}}" class="foto2"> &nbsp;
        <nav class="login2"><h3>{{$login}}</h3>
            <label class="karma">Карма: {{$karmaUser}}</label>
        </nav>

        <nav class="centerInfo">
            <br>
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
                    <form method="POST" action='http://ideal/userInfo?user_id={{$userId}}'>
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
                        <textarea name="comment" id="textCom" placeholder="Введите ваш комментарий"></textarea><br>
                        <input type="submit" name="add" value="добавить">
                    </form>
                </div>
            </nav>
        </nav>
</div>
@stop