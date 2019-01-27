function showDiv(id,type){	
		var type = (type=='pc')?'template_case_pc_mask_':'template_case_mb_mask_';
		var hdiv = document.getElementById(type+id);
		hdiv.style.display = "block";
}
function hideDiv(id,type){
		var type = (type=='pc')?'template_case_pc_mask_':'template_case_mb_mask_';
		var hdiv = document.getElementById(type+id);
		hdiv.style.display = "none";
}

//是否拖拽模板

function isDrag_model(type){
	//alert('/templet/model.php?type='+type);
	window.location.href = '/model.php?type='+type;
}
//模板排序选择

function sort_model(type){
	if (type == 'default'){
		window.location.href = '/model.php?sort='+type;
	}else if (type == 'time'){
		window.location.href = '/model.php?sort='+type;
	}else if (type == 'heat'){
		window.location.href = '/model.php?sort='+type;
	}else if (type == 'price'){
		window.location.href = '/model.php?sort='+type;
	}
}

//收藏模板
function collect(tmpid,number,tmp_type){
	 $.fn.relayblockui("正在进行中，请稍后...");
	 $.post("/json.php?action=collect",
	 { 
       tmpid: tmpid,
       tmp_type : tmp_type,
       number : number
    }
		, function(data){
			$.unblockUI;
			if(data['result']==1)
			{
				$.fn.blockui(data['ret_msg']);
				window.location.href = data['ret_url'];
			}
			else if(data['result']==3)
			{
				$.fn.blockui(data['ret_msg']);
			}
			else if(data['result']==2)
			{
				var msg ='';
				if(data['ret_msg']['flag']=='no')
				{
					msg = '收藏失败';
				}
				else if(data['ret_msg']['flag']=='yes')
				{
					msg = '收藏成功';
				}
				else if(data['ret_msg']['flag']=='has')
				{
					msg = '模板已经收藏, 不用再次收藏.';
				}
				$.fn.blockui(msg);
			}
			else if(data['result']==-1){
				$.fn.blockui(data['ret_msg']);
			}
			else
			{
				 $.fn.blockui(data['ret_msg']);
				 window.location.href = data['ret_url'];
			}
		},'json');
}

function confirmtemplate(tmpid,number,tmp_type){
	var dhtml="";
	var title = "温馨提示";
	var message = "【全局切换】会影响当前站点的布局和模块设置模块数据，建议新站点使用，如需保留当前已经设置好的布局和模块，请选择【样式切换】。强烈建议在切换前进行模板备份。";
	var txt1 = "全局切换";
	var txt2 = "样式切换";
	var txt3 = "取消";
    dhtml+="<div class='window'>";
    dhtml+="    <div class='win-tit'>"+title+"</div>";
    dhtml+="    <div class='win-con'><p>"+message+"</p>";
    dhtml+="    <div class='win-btn'>";
    dhtml+="        <input type='button' value='"+txt1+"' id='btn_Confirmer_OK'/>";
    dhtml+="        <input type='button' value='"+txt2+"' id='btn_Confirmer_STYLE'/>";
    dhtml+="        <input type='buttom' value='"+txt3+"' id='btn_Confirmer_CANCEL'/>";
    dhtml+="    </div></div>";
    dhtml+="</div>";
    $.blockUI({
    	message: dhtml,
             css: {
            	 width: '640px',
                 height: '210px',
                 backgroundColor: '#fff',
                 border: '1px solid #ccc',
                 left: '30%',
                 color: 'green',
                 textAlign: 'center',
                 cursor: 'default',
                 opacity: .7,
                 margin:'0px'
             }
    	});
    $("#btn_Confirmer_OK").click(function(){
    	var type = 'all';
        $.unblockUI();
        usetemplate(tmpid,number,tmp_type,type);   
    });
    $("#btn_Confirmer_STYLE").click(function(){
    	var type = 'style';
        $.unblockUI();
        usetemplate(tmpid,number,tmp_type,type);   
    });
    $("#btn_Confirmer_CANCEL").click(function(){
        $.unblockUI();
    });
}

//使用模板
function usetemplate(tmpid,number,tmp_type,type){
	    $.fn.relayblockui("正在进行中，请稍后...");
	    $.post("/json.php?action=usetemplate",
		{ 
           tmpid: tmpid,
           tmp_type : tmp_type,
           use_type : type,
           number : number
        }
		, function(data){
			$.unblockUI;
			if(data['result']==1)
			{
				$.fn.blockui(data['ret_msg']);
				window.location.href = data['ret_url'];
			}
			else if(data['result']==2)
			{
				var msg ='';
				if(data['ret_msg']['flag']=='failure')
				{
					msg = '使用失败！';
				}
				else if(data['ret_msg']['flag']=='success')
				{
					msg = '使用成功！';
				}
				$.fn.blockui(msg);
			}
			else if(data['result']==3 || data['result']==-1)
			{
				$.fn.blockui(data['ret_msg']);
			}
			else
			{
				 $.fn.blockui(data['ret_msg']);
				 window.location.href = data['ret_url'];
			}
		},'json');
}
//购买版本
function buy_version(ver){
	 $.post("/json.php?action=buy_version",
		{ 
           version: ver
        }
		, function(data){
			if(data['result']==1 || data['result']==0)
			{
				$.fn.blockuiv(data['ret_msg']);
				window.location.href = data['ret_url'];
			}
			else if(data['result']==2)
			{
				 $.fn.blockuiv(data['ret_msg']);
			}
		},'json');
}
//模板选择
function select_model(id,type)
{
	var url;
	var sid = $("#sid").val();
	var zid = $("#zid").val();
	var did = $("#did").val();

	if(type==1){
    var innertag = "#catid";
    }else if(type==2){
    var innertag = "#colorid";
	}else if(type==3){
    var innertag = "#tid";
	}else if(type==4){
    var innertag = "#sid";
	}else if(type==5){
    var innertag = "#zid";
	}else if(type==6){
    var innertag = "#did";
	}
     if(id==$(innertag).val())
	{
	 id = 0;
	}


	if(type==1)
	{
		var colorid = $("#colorid").val();
		var tid = $("#tid").val();
		$("#catid").val(id);
		url = '/ST_ID'+id+'_FID'+colorid+'_TID'+tid+'_SID'+sid+'_ZID'+zid+'_DID'+did+'.html';
	}
	else if(type==2)
	{
		var catid = $("#catid").val();
		var tid = $("#tid").val();
		$("#colorid").val(id);
		url = '/ST_ID'+catid+'_FID'+id+'_TID'+tid+'_SID'+sid+'_ZID'+zid+'_DID'+did+'.html';
	}
	else if(type==3)
	{
		var colorid = $("#colorid").val();
		var catid = $("#catid").val();
		$("#tid").val(id);
		url = '/ST_ID'+catid+'_FID'+colorid+'_TID'+id+'_SID'+sid+'_ZID'+zid+'_DID'+did+'.html';
	}
	else if(type==4)
	{
		var colorid = $("#colorid").val();
		var catid = $("#catid").val();
		var tid = $("#tid").val();
		$("#sid").val(id);
		url = '/ST_ID'+catid+'_FID'+colorid+'_TID'+tid+'_SID'+id+'_ZID'+zid+'_DID'+did+'.html';
	}
	else if(type==5)
	{
		var colorid = $("#colorid").val();
		var catid = $("#catid").val();
		var tid = $("#tid").val();
		$("#zid").val(id);
		url = '/ST_ID'+catid+'_FID'+colorid+'_TID'+tid+'_SID'+sid+'_ZID'+id+'_DID'+did+'.html';
	}
	else if(type==6)
	{
		var colorid = $("#colorid").val();
		var catid = $("#catid").val();
		var tid = $("#tid").val();
		$("#sid").val(id);
		url = '/ST_ID'+catid+'_FID'+colorid+'_TID'+tid+'_SID'+sid+'_ZID'+zid+'_DID'+id+'.html';
	}
	window.location.href = url;
}


//这个函数是验证码点击刷新		
function getCaptcha(id,tag) {
	var str = (tag==1)?'action=top&':'';
	var x = typeof(id)=='codeImg' ? jQuery('#'+id) : jQuery(id);
	x.attr('src', '/captcha.php?'+str+Math.random());
	$(".is_right").css("display","none");
};


$.fn.extend({  
   input_tag:function(id,bind_type,msg_id,msg){
   	$('#'+id).bind(bind_type, function() {
		var cacct = $('#'+id).val();
		if(cacct!='')
		{
			$('#'+msg_id).html('');
		}
		else
		{
			$('#'+msg_id).html(msg);
		}
	});
   },
   reg:function(cacct,pwd,email,verycode,verytag,is_repwd){
   	    var cacct=$("#"+cacct).val();
		var pwd=$("#"+pwd).val();
		var email=$("#"+email).val();
	
		var verycode=$("#"+verycode).val();
   	    if(cacct==""){
		//alert("请输入账号");
		this.blockui("请输入账号");
		$("#"+cacct).focus();
		return false;
	    }
	    if(pwd==""){
		//alert("请输入密码");
		this.blockui("请输入密码");
		$("#"+pwd).focus();
		return false;
	    }
	    if(is_repwd && $("#repwd").val()!=pwd){
	    this.blockui("请输入正确的确认密码");
		$("#repwd").focus();
		return false;
	    }
	    if(email==""){
		//alert("请输入电子邮箱");
		this.blockui("请输入电子邮箱");
		$("#"+email).focus();
		return false;
	    }
	    if(verycode==""){
		//alert("请输入验证码");
		this.blockui("请输入验证码");
		$("#"+verycode).focus();
		return false;
	    }
	    this.relayblockui("正在注册中，请稍后...");
   	$.post("/json.php?action=reg",
		{ 
           username: cacct, 
           password: pwd,
           email: email,
           validCode: verycode,
           verytag: verytag
        }
		, function(data){
			if(data['result'])
			{
				$.unblockUI;
				$.fn.blockui(data['ret_msg']);
				window.location.href = data['ret_url'];
			}
			else
			{
				 $.unblockUI;
				 $.fn.blockui(data['ret_msg']);
			}
		},'json');
   },
   blockui:function(msg){
         $.blockUI({
                    message:msg,
                    css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#198ede',
                    width:"450px",
                    height:"40px",
                    font:"400 24px/45px Microsoft YaHei",
                    opacity: .5,
                    color: '#fff'
                   }
         });
         setTimeout($.unblockUI, 500);
   },
   blockuiv:function(msg){
         $.blockUI({
                    message:msg,
                    css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#198ede',
                    width:"450px",
                    height:"80px",
                    font:"400 24px/45px Microsoft YaHei",
                    opacity: .5,
                    color: '#fff'
                   }
         });
         setTimeout($.unblockUI, 1000);
   },
   relayblockui:function(msg){
         $.blockUI({
                    message:'<p style="font-size:30px;line-height:45px;"><img style="display: inline; height: 26px; padding: 0px 10px 0px 0px;" src="/static/theme/Default/img/loading2.gif" />'+msg+'</p>',
                    css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#198ede',
                    width:"450px",
                    height:"40px",
                    font:"400 24px/45px Microsoft YaHei",
                    opacity: .5,
                    color: '#fff'
                   }
         });
   },
   animate_common:function(the_tag,go_tag){
   	 $(the_tag).animate({scrollTop:$(go_tag).offset().top},1000);
   }
});

$(document).ready(function() {
	$.fn.input_tag('cacct','keyup','dddcacct','账号：');
	$.fn.input_tag('pwd','keyup','dddpwd','密码：');
	$.fn.input_tag('email','keyup','dddemail','电子邮箱：');
	$.fn.input_tag('verycode','keyup','dddverycode','验证码：');
	
	$.fn.input_tag('user','keyup','ddduser','账号：');
	$.fn.input_tag('cipher','keyup','dddcipher','密码：');
	$.fn.input_tag('repwd','keyup','dddrepwd','确认密码：');
	
	$.fn.input_tag('qq','keyup','dddqq','YOU QQ:');
	$.fn.input_tag('email2','keyup','dddemail2','YOU EMAIL:');
	$.fn.input_tag('message','keyup','dddmessage','MASSAGE:');
	
	$.fn.input_tag('topcacct','keyup','dddtopcacct','账号：');
	$.fn.input_tag('toppwd','keyup','dddtoppwd','密码：');
	$.fn.input_tag('topemail','keyup','dddtopemail','电子邮箱：');
	$.fn.input_tag('topverycode','keyup','dddtopverycode','验证码：');
	$(".ddd,.login_form_ddd,.contact_you_input,.contact_you_ddd").click(function(){
	  $(this).parent("div").prev('input').focus();
	});
	$(".contact_you_ddd").click(function(){
	  $(this).parent("div").prev('textarea').focus();
	});
	/*****向下拉开始*****/
	$('.down').click(function(){
	       var tag = parseInt($(this).attr("tag"))*11;
	       $.fn.animate_common("html,body","#"+tag);
	});
	$('.template_case_bottom').click(function(){
	       var tag = parseInt($(this).attr("tag"))*11;
	      $("html,body").animate({scrollTop:$(this).attr("top")},1000);
	});
	$('.up').click(function(){
		
		$('body,html').animate({scrollTop:0},1000);
	});
	
	
	/**联系我们**/
	$('#submit').click(function(){
		var qq = $("#qq").val();
		var email2 = $("#email2").val();
		var message = $("#message").val();
		if(qq==""){
		//alert("请输入账号");
		$.fn.blockui("请输入QQ");
		$("#qq").focus();
		return false;
	    }
	    if(email2==""){
		//alert("请输入密码");
		$.fn.blockui("请输入邮箱");
		$("#email2").focus();
		return false;
	    }
	    if(message==""){
			//alert("请输入密码");
			$.fn.blockui("请输入信息");
			$("#message").focus();
			return false;
		}
	    $.post("/templet/json.php?action=contact",
		{ 
           qq: qq, 
           email: email2,
           message: message
        }
		, function(data){
			if(data['result'])
			{
				$.fn.blockui(data['ret_msg']);
				$('#qq').val("");
				$('#email2').val("");
				$('#message').val("");
				$("#dddqq").html("YOU QQ:");
				$("#dddemail2").html("YOU EMAIL:");
				$("#dddmessage").html("MASSAGE:"); 
			}
			else
			{
				 $.fn.blockui(data['ret_msg']);
				 $('#qq').val("");
				 $('#email2').val("");
				 $('#message').val("");
				 $("#dddqq").html("YOU QQ:");
				 $("#dddemail2").html("YOU EMAIL:");
				 $("#dddmessage").html("MASSAGE:"); 
			}
		},'json');
	});
	
		/**验证码**/
	$("#verifycode").keyup(function(){
		var verifycode = $("#verifycode").val();
		if(verifycode.length==4)
		{
		 $.post("/json.php?action=verifycode",
		{ 
           verifycode: verifycode
        }
		, function(data){
			if(data['ret_code'])
			{
				$(".is_right").css("display","block").attr("src","/static/theme/Default/img/true.png");
			}
			else
			{
				$(".is_right").css("display","block").attr("src","/static/theme/Default/img/close.png");
			}
		},'json');
		}
		else
		{
		   	$(".is_right").css("display","none");
		}	
	});

	
	
	
	/**加盟代理联系**/
	$('#btn').click(function(){
		var qq = $("#qq").val();
		var email = $("#email").val();
		var name = $("#name").val();
		var tel = $("#tel").val();
		var question = $("#question").val();
		var type = $('input:radio:checked').val();
		if(name == ""){
			$.fn.blockui("请输入姓名");
			$("#name").focus();
			return false;
		}
		if(email==""){
			//alert("请输入密码");
			$.fn.blockui("请输入邮箱");
			$("#email2").focus();
			return false;
		    }
		if(qq==""){
		//alert("请输入账号");
		$.fn.blockui("请输入QQ");
		$("#qq").focus();
		return false;
	    }
	    if(tel==""){
			//alert("请输入密码");
			$.fn.blockui("请输入电话");
			$("#tel").focus();
			return false;
		}
	    $.post("/templet/json.php?action=agentin",
		{ 
           qq: qq, 
           email: email,
           tel: tel,
           name:name,
           question:question,
           type:type
        }
		, function(data){
			if(data['result'])
			{
				$.fn.blockui(data['ret_msg']);
				window.location.href = data['ret_url'];
			}
			else
			{
				 $.fn.blockui(data['ret_msg']);
				 window.location.href = data['ret_url'];
			}
		},'json');
	    
	});
	
	
	
	
	
	
	 /**底部注册的**/
	$('#reg').click(function(){
		$.fn.reg('cacct','pwd','email','verycode',0,0);
	});
	/**顶部注册的**/
	$('#topreg').click(function(){
		$.fn.reg('topcacct','toppwd','topemail','topverycode',1,0);
	});
	/**标准注册**/
	$('#commonreg').click(function(){
		$.fn.reg('cacct','pwd','email','verycode',0,1);
	});
	/**登录**/
	$('#login').click(function(){
		var user = $("#user").val();
		var cipher = $("#cipher").val();
		var verifycode = $("#verifycode").val();
		if(user==""){
		//alert("请输入账号");
		$.fn.blockui("请输入账号");
		$("#user").focus();
		return false;
	    }
	    if(cipher==""){
		//alert("请输入密码");
		$.fn.blockui("请输入密码");
		$("#cipher").focus();
		return false;
	    }
	    if (verifycode == "") {
	    	$.fn.blockui("请输入验证码");
			$("#verifycode").focus();
			return false;
	    };
	    $.post("/json.php?action=login",
		{ 
           email: user, 
           password: cipher,
           verifycode: verifycode
        }
		, function(data){
			if(data['result'])
			{
				//$.fn.blockui(data['ret_msg']);
				window.location.href = data['ret_url'];
			}
			else
			{
				 $.fn.blockui(data['ret_msg']);
				 $("#codeImg").attr('src', '/captcha.php?'+Math.random());
				 //window.location.href = data['ret_url'];
			}
		},'json');
	    
	});
	/***退出登录***/
	$("#logout").click(function(){
		$.post("/templet/json.php?action=logout",{ }, function(data){
			if(data['result'])
			{
				//退出登录成功
				$.fn.blockui(data['ret_msg']);
				$('.head_account_back').css('display','none');
				var loginhtml = '<div class="head_account head_login"><a href="/sitelogin.html">登陆</a></div><div class="head_account head_signup"><a href="/siteregister.html">注册</a></div>';
				$('.head_account_back').after(loginhtml);
				
			}
		},'json');
	});
	/***URL留言***/
	$("#urlsubmit").click(function(){
		var content = $('#content').val();
		
		$.post("/templet/json.php?action=urlsubmit",
		{ 
			content : content
		}
		, function(data){
			if(data['result'])
			{
				//返回的信息
				$.fn.blockui(data['ret_msg']);
			}
		},'json');
	});
});