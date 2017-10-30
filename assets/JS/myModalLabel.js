  
$(function() {
    
    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $divForms = $('#div-forms');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;
	var xmlhttp = new XMLHttpRequest();

    //$("form").submit(function () {
	$('#div-forms > form').on('submit', function(e) {
				e.preventDefault();
        switch(this.id) {
            case "login-form":
                //var $lg_username=$('#login_username').val();
               // var $lg_password=$('#login_password').val();
                /*if ($lg_username == "ERROR") {
                    msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "Login error");
                } else {
                    msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "success", "glyphicon-ok", "Login OK");
                }*/
            	
				 $.ajax({
				url:baseUrl+'user_auth/user_login_process',
				type: 'POST',
				data:  $('#login-form').serialize(),
				success: function(msg) {
					if ($.trim(msg) == "YES"){
						msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "success", "glyphicon-ok", "Login OK");
						setTimeout(
							function() 
								{
									window.location.href = "kathullu";
						}, 3000);
						}
					else if ($.trim(msg) == "NO"){
						msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "Login error");
					}
					else{
						msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "unknown error");
					}
					//alert(msg);
				},
				 error: function(xhr, textStatus, error){
				      console.log(xhr.statusText);
				      console.log(textStatus);
				      console.log(xhr.responseText);
				      console.log(error);
				  }
				});
				return false;
                break;
            case "lost-form":
               /* var $ls_email=$('#lost_email').val();
                if ($ls_email == "ERROR") {
                    msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "error", "glyphicon-remove", "Send error");
                } else {
                    msgChange($('#div-lost-msg'), $('#icon-lost-msg'), $('#text-lost-msg'), "success", "glyphicon-ok", "Send OK");
                }*/
            	$.ajax({
    				url:baseUrl+'user_auth/lost_email',
    				type: 'POST',
    				data:  $('#lost_email').serialize(),
    				success: function(msg) {
    					if ($.trim(msg) == "failure")
    						msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "error", "glyphicon-remove", "Register error");
    					else if ($.trim(msg) == "success")
    						msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", "Register OK");
    					else{
    						msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "unknown error");
    					}
    					//alert("hello"+msg);
    				},
    				error: function(xhr, textStatus, error){
				      console.log(xhr.statusText);
				      console.log(xhr.responseText);
				      console.log(textStatus);
				      console.log(error);
				  }
    				});
                return false;
                break;
            case "register-form":
            	/*   var $rg_username=$('#register_username').val();
                var $rg_email=$('#register_email').val();
                var $rg_password=$('#register_password').val();
               if ($rg_username == "ERROR") {
                    msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "error", "glyphicon-remove", "Register error");
                } else {
                    msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", "Register OK");
                }*/
                $.ajax({
    				url:baseUrl+'user_auth/register_user',
    				type: 'POST',
    				data:  $('#register-form').serialize(),
    				success: function(msg) {
    					if ($.trim(msg) == "failure")
    						msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "error", "glyphicon-remove", "Register error");
    					else if ($.trim(msg) == "success")
    						msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", "Register OK");
    					else{
    						msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "unknown error");
    					}
    					//alert("hello"+msg);
    				},
    				error: function(xhr, textStatus, error){
				      console.log(xhr.statusText);
				      console.log(xhr.responseText);
				      console.log(textStatus);
				      console.log(error);
				  }
    				});
                return false;
                break;
            default:
                return false;
        }
        return false;
    });
    
    $('#login_register_btn').click( function () { modalAnimate($formLogin, $formRegister) });
    $('#register_login_btn').click( function () { modalAnimate($formRegister, $formLogin); });
    $('#login_lost_btn').click( function () { modalAnimate($formLogin, $formLost); });
    $('#lost_login_btn').click( function () { modalAnimate($formLost, $formLogin); });
    $('#lost_register_btn').click( function () { modalAnimate($formLost, $formRegister); });
    $('#register_lost_btn').click( function () { modalAnimate($formRegister, $formLost); });
    
    function modalAnimate ($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height",$oldH);
        $oldForm.fadeToggle($modalAnimateTime, function(){
            $divForms.animate({height: $newH}, $modalAnimateTime, function(){
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }
    
    function msgFade ($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function() {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }
    
    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function() {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
  		}, $msgShowTime);
    }
});