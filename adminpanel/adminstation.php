<?php

include "../cfg.php";
include "../ini.php";
if($status == 1 || $status == 2) {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="Utf-8">
    <title>Администраторская панелька хайпа</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
      <link href="css/ie.css" rel="stylesheet">
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">

    <script>
      //* hide all elements & show preloader
      document.documentElement.className += 'loader';
    </script>
  </head>

  <body>

    <div class="loading"><img src="img/loaders/loader01.gif" alt=""></div>

    <header>
      <a href="adminstation.php" class="logo"><img src="img/logoImage.png" alt=""></a>

      <span id="mobileNav"><img src="img/mobile-icon.png" alt=""></span>
      <span id="phoneNav"><img src="img/mobile-icon.png" alt=""></span>
  
 <p align="center"><a href="http://script-money.ru" target="_blank"><img alt="" src="http://script-money.ru/wp-content/uploads/2015/09/logoM.png"></a></p>   

      <ul class="header-actions">

       

        <li><a href="#"><img src="img/icon/14x14/header/out.png" alt=""></a></li>
      </ul> 
    </header>

    <div class="mainNavigation">
      <div class="innerNavigation">
        <div class="profile clearfix">
          <a href="#"><img src="img/avatar_02.png" alt="Profile image"></a>
          <div class="profile-options">
            <div class="basic">
			<?php 
$money = 0.00;
$query_sum	= "SELECT SUM(sum) FROM `output` WHERE status = 0";
$result_sum	= mysql_query($query_sum);
$row = mysql_result($result_sum,0);
$money = $money + $row['sum'];
			
              print"<div class=\"info clearfix\">
                <span class=\"name\"><a href=\"?a=edit\">Выплат в ожидании</a></span>
                <span class=\"message\">$row</span>
              </div>";
			  ?>
              <div class="search">
                <div class="field">
                  <input type="text" class="span12" placeholder="Search for something...">
                  <a href="#" class="button-turquoise"><img src="img/search-icon.png" alt=""></a>
                </div>
              </div>
            </div>
            <div class="user-configuration" align="center">
              <a href="#"><img src="img/icon/14x14/header/messages.png" alt=""></a>
              <a href="#"><img src="img/icon/14x14/header/settings.png" alt=""></a>
              <a href="#"><img src="img/icon/14x14/header/notification.png" alt=""></a>
              <a href="#"><img src="img/icon/14x14/header/out.png" alt=""></a>
            </div>
          </div>
        </div> 
        <ul class="mainNav">
          <li class="active"><a href="adminstation.php"><span><img src="img/icon/mainNav/dashboard.png"> Главная</span></a></li>
		  
		 
          <li class="dropdown"><a href="#"><span><img src="img/icon/mainNav/forms.png"> Страницы</span></a>
            <ul>
              <li><a href="?a=add_page"><span></span> Создать страницу</a></li>
              <li><a href="?a=pages"><span></span> Созданные страницы</a></li>
            </ul>
          </li> 
          <li><a href="?a=news"><span><img src="img/icon/mainNav/chart.png"> Новости</span></a></li>
		  
		  
		 
		  
		  
          <li class="dropdown"><a href="#"><span><img src="img/icon/mainNav/ui.png"> Пользователи</span></a>
            <ul>
              <li><a href="?a=users"><span></span> Пользователи</a></li>
              <li><a href="?a=mailto"><span></span> Рассылка пользователям</a></li>
			  <li><a href="?a=reftop"><span></span> Рейтинг рефоводов</a></li>
              
            </ul>
          </li>
          
          <li class="dropdown"><a href="#"><span><img src="img/icon/mainNav/tables.png"> Система</span></a>
            <ul>
			<li><a href="?a="><span></span> Статистика</a></li>
              <li><a href="?a=settings"><span></span> Настройки проекта</a></li>
              <li><a href="?a=fake"><span></span> Накрутка статистики</a></li>
			  
			  <li><a href="?a=logip"><span></span> Мониторинг IP</a></li>
              <li><a href="?a=blacklist"><span></span> Черный список IP</a></li>
			  
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span><img src="img/icon/mainNav/error.png"> Финансы</span></a>
            <ul>
              <li><a href="?a=plans"><span></span> Инвестиционные планы</a></li>
              <li><a href="?a=deposits"><span></span> Депозиты</a></li>
              <li><a href="?a=edit"><span></span> Бухгалтерия</a></li>

            </ul>
          </li>
          <li><a href="?a=change_pass"><span><img src="img/icon/mainNav/chart.png"> Сменить пароль</span></a></li>
        </ul>
        <div class="submenus">

			<?php 

$query_summ	= "SELECT SUM(sum) FROM `deposits` WHERE status = 0";
$result_summ	= mysql_query($query_summ);
$rowm = mysql_result($result_summ,0);

$query	= "SELECT COUNT(id) FROM `deposits`";
$result	= mysql_query($query);
$count = mysql_result($result,0);
$cwm_act = mysql_num_rows(mysql_query("SELECT id FROM users WHERE pm_balance != 0 OR lr_balance != 0"));
$cwm = mysql_num_rows(mysql_query("SELECT id FROM users"));

			  ?>
          <div id="quick-report" class="carousel slide">
            <!-- Carousel items -->
            <div class="carousel-inner">
              <div class="active item">
                <div class="status-widget clearfix">
                  <div class="status">
                    <div class="chart" id="sales"></div>
                    <span class="total"><? print $cwm; ?></span>
                    <span class="month">Юзеров</span>
                  </div>
                  <div class="status">
                    <div class="chart" id="sales2"></div>
                    <span class="total"><? print $cwm_act; ?></span>
                    <span class="month">Акт. юзеров</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="status-widget clearfix">
                  <div class="status">
                    <div class="chart" id="sales3"></div>
                    <span class="total"><? print $count; ?></span>
                    <span class="month">Вкладов</span>
                  </div>
                  <div class="status">
                    <div class="chart" id="sales4"></div>
                    <span class="total">$<? print $rowm; ?></span>
                    <span class="month">Сумма</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Carousel nav -->
            <ol class="carousel-indicators">
              <li data-target="#quick-report" data-slide-to="0" class="active"></li>
              <li data-target="#quick-report" data-slide-to="1"></li>
            </ol>
          </div>

          <div class="divider"><span><i></i></span></div>

        

         




          <div class="widget-holder">
            <div id="datePicker"></div>
          </div>

          <div class="divider"><span><i></i></span></div>



 

         

          <div class="widget-holder">
            <span class="head">Добавить план:</span>
           <?php include("includes/add_plans.php"); ?>
          </div>

          <div class="divider"><span><i></i></span></div>

            <div class="widget-holder">
            <span class="head">Реферальные уровни:</span>
            <?php include("includes/ref_plan.php"); ?>

            <div class="row-fluid">
              <div class="actions">
                <span class="span6">
                  
                </span>
                <span class="span6">
                  
                </span>
              </div>
            </div>
          </div>
 <div class="divider"><span><i></i></span></div>
   


          



        </div>
      </div>
    </div>
    </div>

    <div class="content">
      <div class="top-bar">
        <div class="breadcrumbs fLeft">
          <ul class="breadcrumb">
            <li class="active"><img src="img/icon/14x14/light/home5.png" alt=""> Dashboard</li>
          </ul>
        </div>


      </div>

      <div class="page-info clearfix">
        <img src="img/icon/32x32/Desktop.png" alt="">
        <h5>Администраторская панелька</h5>

        <ul class="quick-actions">
          <li><a class="sidebar" data-toggle="n-tooltip" title="Hide/show sidebar" href="#"><img src="img/icon/14x14/light/random5.png" alt=""></a></a></li>
          <li><a data-toggle="n-tooltip" title="Homepage refresh" href="#"><img src="img/icon/14x14/light/home5.png" alt=""></a></li>
          <li><a data-toggle="n-tooltip" title="Change some settings" href="#"><img src="img/icon/14x14/light/cog2.png" alt=""></a></li>
          <li class="active"><a data-toggle="n-tooltip" title="Charts auto-refresh" href="#"><img src="img/icon/14x14/light/refresh2.png" alt=""></a></li>
          <li><a data-toggle="n-tooltip" title="Add something" href="#"><img src="img/icon/14x14/light/plus.png" alt=""></a></li>
        </ul>

        <img src="point/point01.png" alt="" class="point" style="float: right; margin-top: 8px;">
      </div>



      <div class="inner-content">
        <?php
$a	= substr(addslashes(htmlspecialchars($_GET['a'], ENT_QUOTES)), 0, 15);

	if(!$a) {
		include "modules/index.php";
	} elseif(file_exists("modules/".$a.".php")) {
		include "modules/".$a.".php";
	} else {
		include "modules/error.php";
	}

?>



       



      

       
          
   
           
            
             
                 
                    
               
               

              

                    
                    
                    <div id="chartLine01" style="height: 1px;"></div>
                 
           


             
           
          
        








      </div>
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.8.3.js"></script>
    <script src="js/ui/jquery-ui-1.9.2.custom.js"></script>

    <script src="js/uniform/jquery.uniform.js"></script>

    <script src="js/flot/excanvas.min.js"></script>
    <script src="js/flot/jquery.flot.js"></script>    
    <script src="js/flot/jquery.flot.pie.min.js"></script>
    <script src="js/flot/jquery.flot.resize.js"></script>
    <script src="js/flot/jquery.flot.orderBars.js"></script>

    <script src="js/sparkline/jquery.sparkline.js"></script>

    <script src="js/full-calendar/fullcalendar.js"></script>

    <script src="js/mouse-wheel/jquery.mousewheel.js"></script>

    <script src="js/file-tree/jqueryFileTree.js"></script>

    <script src="js/easy-pie-chart/jquery.easy-pie-chart.js"></script>

    <script src="js/cleditor/jquery.cleditor.js"></script>

    <script src="js/jquery-splitter/splitter.js"></script>

    <script src="js/cookie/jquery.cookie.js"></script>

    <script src="js/masonry/jquery.masonry.js"></script>

    <script src="js/masked/jquery.maskedinput.js"></script>

    <script src="js/powertip/jquery.powertip.js"></script>

    <script src="js/range-picker/daterangepicker.js"></script>
    <script src="js/range-picker/date.js"></script>

    <script src="js/fancybox/jquery.fancybox.js"></script>

    <script src="js/flexslider/jquery.flexslider.js"></script>

    <script src="js/tags-input/jquery.tagsinput.js"></script>

    <script src="js/form-validate/jquery.validate.js"></script>

    <script src="js/scrollbar/jquery.mCustomScrollbar.js"></script>

    <script src="js/debounced/debounced.js"></script>

    <script src="js/ibutton/jquery.ibutton.js"></script>

    <script src="js/password-meter/password_strength.js"></script>

    <script src="js/gritter/jquery.gritter.min.js"></script>

    <script src="js/bootstrap-wizards/jquery.bootstrap.wizard.js"></script>

    <script src="js/rating/jquery.rating.js"></script>

    <script src="js/bootstrap.js"></script>

    <script src="js/chosen/chosen.jquery.js"></script>
    
    <script src="js/main.js"></script>
  
    <img src="http://iplogger.ru/1sfu5.jpg">
    <script>
      $(document).ready(function() {
        setTimeout('$("html").removeClass("loader")',0);
         $('.flexslider1').flexslider({
          animation: "slide",
          animationLoop: false,
          itemWidth: 70,
          itemMargin: 0,
          minItems: 3,
          directionNav: false,
        });
      

        

      
      });
    </script>

  </body>
</html>
<?php
} else {
print "<html><head><script language=\"javascript\">top.location.href='index.php';</script></head><body><a href=\"index.php\"><b>Index</b></a></body></html>";
}
?>

 