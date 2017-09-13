<? include("includes/head.php"); ?>
		<script type="text/javascript" src="/jquery.js"></script>
		<script type="text/javascript" src="/sliding_effect.js"></script>
				<!-- Navigation End Begin -->

				<!-- Navigation Content End -->
			
			<!-- Megamenu Begin -->
			
			<!-- Megamenu End -->
				
			</div>

		</div>
		<!-- Navigation End -->

		<br class="clear"/>
		
		<!-- Main Content Begin -->
		<div class="main-content float-right">
			<div class="main-content-inner">
			

				
<?php
	if(!$page) {
		include "includes/index.php";
	} elseif(file_exists("../".$page."/index.php")) {
		include "../".$page."/".$file;
	} else {
		include "includes/errors/404.php";
	}
?>
			
			</div>
		</div>
		<!-- Main Content End -->
		
		<!-- Left Sidebar Begin -->
		<div class="sidebar left float-left">
			

<?php
if(!$login) {
?>			
			<!-- Categories Begin -->

			
			            <ul id="sliding-navigation">
                <li class="sliding-element"><h3><b>Навигация</b></h3></li>
                <li class="sliding-element"><a href="/auth/">Регистрация</a></li>
                <li class="sliding-element"><a href="/faq">F.A.Q</a></li>
                <li class="sliding-element"><a href="/news/">Новости</a></li>


            </ul>			
			
			
			<!-- Categories End -->
<?php
} else {
?>

			
			            <ul id="sliding-navigation">
                <li class="sliding-element"><h3><b>Аккаунт</b></h3></li>
                <li class="sliding-element"><a href="/deposit">Сделать депозит</a></li>
                <li class="sliding-element"><a href="/deposits">Мои депозиты</a></li>
                <li class="sliding-element"><a href="/enter/">Пополнить баланс</a></li>
                <li class="sliding-element"><a href="/withdrawal/">Вывести средства</a></li>
                <li class="sliding-element"><a href="/ref/">Рекламные материалы</a></li>
				<li class="sliding-element"><a href="/stat/">Статистика</a></li>
				<li class="sliding-element"><a href="/profile/">Профиль</a></li>
				<li class="sliding-element"><a href="/exit.php">Выход</a></li>
            </ul>
			
			<!-- Categories End -->
<?
}
?>		
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			

			
			
			
		</div>
		<!-- Left Sidebar End -->
		
		<br class="clear"/>

	</div>
	
	<? include ("includes/foot.php"); ?>
	<script type="text/javascript">
	
	$(function() {

		// Image mouse hover effect
		$('.circle').mosaic({
					opacity		:	0.8			//Opacity for overlay (0-1)
				});
				
		$('.fade').mosaic();
		
		$('.bar').mosaic({
			animation	:	'slide'		//fade or slide
		});
		
	});
	
	$(window).load(function(){

    });
	
	$(document).ready(function() {
		
		$('#main-menu').mobileMenu();
		
		$('#weather').weatherfeed(['USCA0090'],{
			unit: 'c',
			image: true,
			country: true,
			highlow: true,
			wind: false,
			sunrise: true,
			sunset: true,
			link: false,
			linktarget: '_blank'
		});

		// Navigation menu
		$('ul.sf-menu').superfish({ 
			hoverClass:    'sfHover', 
			delay: 100
		});  
		
		// Mouseover effect for thumbnails
		$("a.grouped-elements").hover(function() {
			  $(this).find(".imagehover").toggleClass("mouseon");
		});
		
	});
	
</script>

</body>
</html>