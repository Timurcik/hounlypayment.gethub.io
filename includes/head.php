<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="/bitrix/js/main/core/css/core.css@1372685196" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/stem/styles.css@1372855668" type="text/css" rel="stylesheet" />
<link href="/bitrix/templates/stem/template_styles.css@1372855668" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style2.css">
<script type="text/javascript" src="/bitrix/js/main/core/core.js@1372685196"></script>
<script type="text/javascript" src="/bitrix/js/main/core/core_ajax.js@1372685196"></script>
<script type="text/javascript" src="/bitrix/js/main/session.js@1372685196"></script>
<script type="text/javascript" src="/js/scriptM.js"></script>

  <title>HourlyPayment.org - Почасовые выплаты</title>
  <link rel="stylesheet" href="/bitrix/templates/stem/styles/screen.css" type="text/css" />
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
  <script src="/bitrix/templates/stem/js/jquery-1.9.1.min.js"></script>
  <script src="/bitrix/templates/stem/js/superfish.js"></script>
  <script src="/bitrix/templates/stem/js/jquery-ui-1.10.3.custom.min.js"></script>
  <script src="/bitrix/templates/stem/js/jquery.lavalamp.js"></script> 
  <script src="/bitrix/templates/stem/js/jquery.jcarousel.min.js"></script>
  <script>
  function jcarousel_initCallback(carousel)
  {
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
  };
    jQuery(document).ready(function(){
      jQuery('ul.menu-navbar').superfish({
          pathClass: 'root-active',
          pathLevels: 2
      });
      $("ul.menu-navbar").lavaLamp({ fx: "easeOutQuart", speed: 1500 })
      $('.jcarousel').jcarousel({
        // Configuration goes here
        auto: 2,
        scroll: 1,
        wrap: 'circular',
        initCallback: jcarousel_initCallback
      });
    });
  </script>
  
    <style type='text/css'>
.popup__overlay {
	z-index: 999;
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,.7);
    text-align: center
    }
    .popup__overlay:after {
        display: inline-block;
        height: 100%;
        width: 0;
        vertical-align: middle;
        content: ''
    }
.popup {
    display: inline-block;
    position: relative;
    max-width: 80%;
    padding: 20px;
    border: 5px solid #fff;
    border-radius: 15px;
    box-shadow: inset 0 2px 2px 2px rgba(0,0,0,.4);
    background: #fff;
    vertical-align: middle
    }
.popup-form__row {
    margin: 1em 0
    }
label {
    display: inline-block;
    width: 120px;
    text-align: left
    }
input[type="text"], input[type="password"] {
    margin: 0;
    padding: 2px;
    border: 1px solid;
    border-color: #999 #ccc #ccc;
    border-radius: 2px
    }
input[type="button"] {
    padding: 6px 16px;
    border: 0;
    border-radius: 2px;
    -webkit-box-shadow: inset 0 1px 1px rgba(255,255,255,.3);
    box-shadow:         inset 0 1px 1px rgba(255,255,255,.3);
    cursor: pointer;
    background: #444;
    background: -webkit-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:    -moz-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:     -ms-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:      -o-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:         linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    color: #fff
    }
	
input[type="submit"] {
    padding: 6px 16px;
    border: 0;
    border-radius: 2px;
    -webkit-box-shadow: inset 0 1px 1px rgba(255,255,255,.3);
    box-shadow:         inset 0 1px 1px rgba(255,255,255,.3);
    cursor: pointer;
    background: #444;
    background: -webkit-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:    -moz-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:     -ms-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:      -o-linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    background:         linear-gradient(90deg, #515151, #333 48%, #333 52%, #515151 100%);
    color: #fff
    }	
.popup__close {
    display: block;
    position: absolute;
    top: -20px;
    right: 10px;
    width: 12px;
    height: 12px;
    padding: 8px;
    border: 5px solid #fff;
    border-radius: 50%;
    -webkit-box-shadow: inset 0 2px 2px 2px rgba(0,0,0,.4),
                              0 3px 3px     rgba(0,0,0,.4);
    box-shadow:         inset 0 2px 2px 2px rgba(0,0,0,.4),
                              0 3px 3px     rgba(0,0,0,.4);
    cursor: pointer;
    background: #fff;
    text-align: center;
    font-size: 12px;
    line-height: 12px;
    color: #444;
    text-decoration: none;
    font-weight: bold
    }
    .popup__close:hover {
        background: #ddd
        }

  </style>
  
 <script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
p = $('.popup__overlay')
$('#popup__toggle').click(function() {
    p.css('display', 'block')
})
p.click(function(event) {
    e = event || window.event
    if (e.target == this) {
        $(p).css('display', 'none')
    }
})
$('.popup__close').click(function() {
    p.css('display', 'none')
})
});//]]>  

</script> 
  
  
</head>



<body>
<script type="text/javascript" src="http://gostats.ru/js/counter.js"></script>
<script type="text/javascript">_gos='c4.gostats.ru';_goa=407459;
_got=5;_goi=1;_gol='анализ сайта';_GoStatsRun();</script>
<noscript><a target="_blank" title="анализ сайта" 
href="http://gostats.ru"><img alt="анализ сайта" 
src="http://c4.gostats.ru/bin/count/a_407459/t_5/i_1/counter.png" 
style="border-width:0" /></a></noscript>

    <div id="panel"></div>
    <div id="header">
      <div id="header-top">
        <div id="header-top-container">
           <div id="little-menu">
             <ul>

<?php
$cusers		= mysql_num_rows(mysql_query("SELECT id FROM users")) + cfgSET('fakeusers');
$cwm		= mysql_num_rows(mysql_query("SELECT id FROM users WHERE pm_balance != 0 OR lr_balance != 0")) + cfgSET('fakeactiveusers');

$money	= cfgSET('fakewithdraws');
$query	= "SELECT sum FROM output WHERE status = 2";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$money = $money + $row['sum'];
}

$depmoney	= cfgSET('fakedeposits');
$query	= "SELECT sum FROM deposits WHERE status = 0";
$result	= mysql_query($query);
while($row = mysql_fetch_array($result)) {
	$depmoney = $depmoney + $row['sum'];
}
?>

<li>Старт: <b><?php print date("d.m", cfgSET('datestart')); ?> 19:00</b></li>
						<li>Пользователей: <b><?php print $cusers; ?></b></li>
						<li>Депозитов: <b><?php print $depmoney; ?>$</b></li>
						
						<li>Выплачено: <b><?php print $money; ?>$</b></li>
             </ul>
           </div>
		   
		   				<?php
if(!$login) {
?>
           <div id="registration">
             <img src="/bitrix/templates/stem/images/key.png" />
             <a href="/auth/">Регистрация</a>
           </div>
		   <div id="enter-button">
  <p><input type="button" value="Вход" id="popup__toggle" /></p>
		   </div>
		   <div class="popup__overlay">
    <div class="popup">
        <a href="#" class="popup__close">X</a>
        <h2>Добро пожаловать!</h2>
        <p>Введите логин и пароль что бы войти на сайт.</p>
        <form  action="/login/" method="post" autocomplete="on">
		<div class="popup-form__row">
            <label for="popup-form_login">Логин</label>
            <input type="text" name="user" required="required" id="popup-form_login" value="" />
        </div>
        <div class="popup-form__row">
            <label for="popup-form_password">Пароль</label>
            <input type="password" name="pass" required="required" id="popup-form_password" value="" />
        </div>
		<a style="text-align: right;" href="/reminder">Забыли пароль?</a><br>
        <input type="submit" value="Войти" />
		</form>
    </div>
				<?php
} else {
?>

           <div id="registration">
             <img src="/bitrix/templates/stem/images/money.png" />
             <a href="/deposit">Баланс: $<b><?php print"$balance"; ?></b></a>
           </div>
		   <div id="enter-button">
        <p><input type="button" onClick="window.location='/deposit'" value="Личный кабинет" /></p>
    </div>
	</div>

<?
}
?>	
	
	
	
</div>
		   
        </div>
      </div>
      <div id="header-bottom">
        <div id="header-bottom-container">
           <div id="logo-box">
             <img src="/bitrix/templates/stem/images/logo_image.png" id="logo-image">
             <a href="/"><img src="/bitrix/templates/stem/images/stem.png" id="stem"></a>
             <p>Выплаты каждый час</p>
           </div>
           <div id="contacts-box">
             <div class="contact-1">
               <div class="contact-2">
                 <table>
                   <tr>
                     <td><img src="/bitrix/templates/stem/images/mail.png"></td>
                     <td><a target="_blank" href="mailto:admin@houlypayment.org">admin@houlypayment.org</a></td>
                   </tr>
                   <tr>
                     <td><img src="/bitrix/templates/stem/images/skype.png"></td>
                     <td><a href="skype:hourlypayment.org?chat">Скайп админа</a> (только чат)</td>
                   </td>
				   <tr>
                     <td><img src="/bitrix/templates/stem/images/skype.png"></td>
                     <td><a href="skype:?chat&blob=iKTvKmQ9sv82rH__8owgYpzhrBIykP_jzKXEI5sqjqvZv_jC8GcapqlaMirL2m6YmHuj2SDEje-h">Скайп чат</a></td>
                   </td>
                 </table>
               </div>
             </div>

             <div class="contact-1">
               <div class="contact-2">
<img src="/pm.jpg" >
               </div>
             </div>
           </div>
        </div>
      </div>
    </div><!-- #header end -->
      <div id="main-menu">
        <div id="main-menu-container">
          <ul class="menu-navbar">
				<li><span><a href="/">Главная</a></span></li>
				<li ><span><a href="/news">Новости</a></span></li>
				<li ><span><a href="/faq">Вопрос-ответ</a></span></li>
				<li ><span><a href="/forums">Форумы и мониторинги</a></span></li>
		
				</ul>
				</li>				
				
				</ul>
 

        </div>
      </div>
      <div id="main-menu-after">
      </div>