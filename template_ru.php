

<? include("includes/head.php"); ?>
			<!-- Navigation End Begin -->
			<? include ("includes/menu_head.php"); ?>
			<!-- Navigation Content End -->
			<!-- Megamenu Begin -->
			
			<!-- Megamenu End -->
				
			</div>
			<div class="navigation-shadow"></div>
		</div>
		<!-- Navigation End -->

		<br class="clear"/>
		
		<!-- Main Content Begin -->
		<div class="main-content-full">
			
				<!-- Breadcrumbs Begin -->
				<div class="general-block-outer">
					<div class="general-block breadcrumbs">
						<ul class="breadcrumbs">
							<li class="home"><a href="#"><img src="../images/green/breadcrumbs_home.png" border="0"/></a></li>
							<li><a href="#">Контактная информация</a></li>
							
						</ul>
						<br class="clear"/>
					</div>
				</div>
				<!-- Breadcrumbs End -->
				
				<!-- Contacts Begin -->
				
				<div class="one-half float-left">
				
					<!-- Form Begin -->
<?php
	if(!$page) {
		include "includes/index.php";
	} elseif(file_exists("../".$page."/index.php")) {
		include "../".$page."/".$file;
	} else {
		include "includes/errors/404.php";
	}
?>
					<!-- Form End -->

				</div>

				<div class="one-half float-right address">
					<h3>Контактная информация</h3>

						
					<div class="office-email">
						<p><a href="#" class="regular">admin@investors-company.biz</a></p>
					</div>

				</div>

				<br class="clear"/>
				
			

				
				<!-- Contacts End -->

		</div>
		<!-- Main Content End -->
		
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