@extends('ideal/auth/template')
@section('content')
<div><nav class="textcontainer_l">
        
        <h2>Лучшие люди Интернета</h2>
    </nav>
</div>

<div class="people" id="people">
            <br>     
            <br>   
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
            <div id="people2" class="people2">
              
            </div>
</div>
@stop