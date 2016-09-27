$(document).ready(function()
{
    (function($) {
    var actions = {
            start: function() {
                var $preloader = $("<div id='jpreloader' class='preloader-overlay'><div class='loader' style='position:absolute;left:50%;top:50%;margin-left:-24px;margin-top:-24px;'><svg width='48px' height='48px' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100' preserveAspectRatio='xMidYMid' class='uil-default'>...</svg></div></div>");
                $preloader.css({
                    'background-color': '#4c4c4c',
                    'width': '100%',
                    'height': '100%',
                    'left': '0',
                    'top': '0',
                    'opacity': '0.3',
                    'z-index': '100',
                    'position': 'absolute'
                });
                this.append($preloader);
            },

            stop: function() {
                this.find('.preloader-overlay').remove();
            }
        };

        $.fn.preloader = function(action) {        
            actions[action].apply(this);
            return this;
        };
    }(jQuery));
      $('.centerInfo').preloader('stop');
    function usersPop()
    {
        
    }
    usersPop.prototype.showPeople = function()
    {
        var popular = this.getPopularPeople();
        var zext = '';
        popular.forEach(function(object)
            {
                
                var karmaDiv = '';
                
                if(object.Karma_change != 'false')
                {
                    if(object.Karma_change == '1')
                    {
                        karmaDiv = "<div  ><img src='./foto/default/plusOn.jpg'></div>";
                        karmaDiv += "<div class= 'minus' id='"+object.user_id+"'><img src='./foto/default/minus.png'></div>";
                    }
                    else if(object.Karma_change == '0')
                    {
                        karmaDiv = "<div class='plus' id='"+object.user_id+"'><img src='./foto/default/plus.jpg'></div>";
                        karmaDiv += "<div  ><img src='./foto/default/minusOn.png'></div>";
                    }
                }
                else
                {
                        karmaDiv = "<div class='plus' id='"+object.user_id+"'><img src='./foto/default/plus.jpg'></div>";
                        karmaDiv += "<div class= 'minus' id='"+object.user_id+"'><img src='./foto/default/minus.png'></div>";
                }
                var t = "&nbsp<div class='bord'><img src='"+object.foto+"'><label class='karmas'>"+object.karma+"</label><br>";
                t += "<a href='http://ideal/userInfo?user_id="+object.user_id+"'>"+object.login+"</a><div class='karmas2'>";
                t +=  karmaDiv;
                t += "</div><br><br></div><br><br>";
                zext += t;
            });       
            $('#people2').html(zext);
    };
    usersPop.prototype.getPopularPeople = function()
    {
        var answet ;
        var token =$('#_token').val() ;
        $.ajax({
            url: "peoplePop",
            async: false,
            type: 'POST',
            data:{'_token':token},
            cache: false,
            success: function (data) {
               answet = data;
            }
            
        });//конец ajax
       return answet;
    };
    usersPop.prototype.plus = function(token,user_id)
    {
      
         $.ajax({
            url:'plus',
            beforeSend: function()
            {
              
            },
            async: false,
            type: 'POST',
            cache: false,
            data: {_token:token,user_id:user_id},
            success: function () {
                
            }
       });//конец ajax
      
        
    };
    usersPop.prototype.minus = function(token,user_id)
    {
        $.ajax({
            url:'minus',
            async: false,
            type: 'POST',
            cache: false,
            data: {_token:token,user_id:user_id},
            success: function (data) {
                console.log(data);
                 
            }
       });//конец ajax
        
    };
    
   $(".file-upload input[type=file]").change(function()
   {
       var filename = $(this).val().replace(/.*\\/,"");
       $("#filename").val(filename);
   }) ;
 function validateSize(fileInput,size)
        {
            var fileObj, oSize;
            if ( typeof ActiveXObject == "function" ) { // IE
              fileObj = (new ActiveXObject("Scripting.FileSystemObject")).getFile(fileInput.value);
            }else {
                fileObj = fileInput.files[0];
            }
 
            oSize = fileObj.size; // Size returned in bytes.
            if(oSize > size * 1024 * 1024){
                return false;
            }
            return true;
        }
  $('#foto').change(function()
  {
     
      if(!validateSize(this,5)){
          $('#errorFoto').text('Размер файла превышает 5Мб');
          submit.setAttribute('hidden','');
        }
        else
        {
          $('#errorFoto').text('');
          submit.removeAttribute('hidden');
        }
       
  });
    var people = new usersPop();
    people.showPeople();
    
    $(document).on('click',"div.plus",function(e)
    {
                
       var user_id = $(this).attr('id');
       var token = $('#_token').val();
       $('#people').preloader('start');
      setTimeout(function(){  people.plus(token,user_id);
       people.showPeople();}
             ,10);
       setTimeout(function()
         {
             $('#people').preloader('stop');
         },300);
      
    });
    $(document).on('click',"div.minus",function(e)
    {
       var user_id = $(this).attr('id');
       var token = $('#_token').val();
        $('#people').preloader('start');
       setTimeout(function(){  people.minus(token,user_id);
       people.showPeople();}
             ,100);
         setTimeout(function()
         {
             $('#people').preloader('stop');
         },300);
    });
    
    $(document).on('click',"div.plusUser",function(e)
    {
        var user_id = $(this).attr('id');
        var token = $('#_token').val();
        $('.centerInfo').preloader('start');
        people.plus(token,user_id);
       var oldloc = location;
        location = oldloc;
    });
    $(document).on('click','div.minusUser',function(e)
    {
        var user_id = $(this).attr('id');
        var token = $('#_token').val();
         $('.centerInfo').preloader('start');
        people.minus(token,user_id);
        var oldloc = location;
        location = oldloc;
    });
   
   
});
