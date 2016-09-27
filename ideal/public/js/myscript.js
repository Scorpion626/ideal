$(document).ready(function()
{
    function ShowHidePassword(id)
    {
        var elem = document.geteElementById(id);
        if (elem.type == 'password')
        {
            elem.type = 'text';
        }
        else
        {
            elem.type = 'password';
        }
    }
   
    function getPopularPeople()
    {
        var answet ;
        var token =$('#_token').val() ;
        $.ajax({
            url: "people",
            async: false,
            type: 'POST',
            data:{'_token':token},
            cache: false,
            success: function (data) {
               answet = data;
            }
            
        });//конец ajax
       return answet;
    }
   
    function showPeople()
    {
        popular.forEach(function(object)
        {
            //console.log(object.user_id);
           
            
            var t = "&nbsp<div class='bord'><img src='"+object.foto+"'><label class='karmas'>"+object.karma+"</label><br>";
                t += "<a href='http://ideal/userInfo?user_id="+object.user_id+"'>"+object.login+"</a>";
                t +=    "<div class='reg'> <img src='./foto/default/plus.jpg'><br>";
                t +=    "<img src='./foto/default/minus.png'></div>";
                t += "</div><br><br></div><br><br>";
               
            $('#people2').append(t);
        });
    }
    
   $(".file-upload input[type=file]").change(function()
   {
       var filename = $(this).val().replace(/.*\\/,"");
       $("#filename").val(filename);
   }) ;
 
    var popular = getPopularPeople();
    showPeople(popular);
    
    $("div.reg").click(function()
    {
        window.location.href = 'http://ideal/registration?msg=1';
    });
    $("div.registrationGo").click(function()
    {
        window.location.href = 'http://ideal/registration?msg=1';
    });
    $('#check').bind('click',function(){
        var pss = $("#password").val();
       var checked = $('#check').prop('checked');
      
        if(checked)
        {
             $('#passField').html("<input type='text' id='password' name='password' value="+pss+">");
        }
        else
        {
            $('#passField').html("<input type='password' id='password' name='password' value="+pss+">");
        }
        
    });
     $(document).on('click','#checkConf',function(){
       var pss = $("#password_conf").val();
       var checked = $('#checkConf').prop('checked');
     
        if(checked)
        {
             $('#passFieldCon').html("<input type='text' id='password_conf' name='password_confirmation' value="+pss+">");
        }
        else
        {
            $('#passFieldCon').html("<input type='password' id='password_conf' name='password_confirmation' value="+pss+">");
        }
        
    });
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
});