    <div id="footer">
      <div  id="footer-container">
        <div id="footer-left">

             <a href="/"><img src="/bitrix/templates/stem/images/stem.png" id="stem"></a>


        </div>
		
        <div id="footer-right">
		
        <br/>
        &copy; 2015 "<a></a><p align="center"><a href="http://script-money.ru" target="_blank">
        script-money
        </div>
      </div>
    </div><!-- #footer end -->
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
 <p align="center"><a href="http://script-money.ru" target="_blank"><img alt="" src="http://script-money.ru/wp-content/uploads/2015/09/uTVJN22.jpeg"></a></p>  

  </body>
</html>