<? include("includes/head.php"); ?>
				
          <div id="orange-banner">
        <div id="blink">
          <div id="orange-banner-container">
            <div id="orange-left">
              <div id="orange-left-top">
                <p id="reliable">надёжные</p>
                <p id="price">от <span>0.8</span> %/час</p>
                <img id="hosting" src="/bitrix/templates/stem/images/vklad.png">
              </div>
              <div id="orange-left-bottom">
                <ul>
                  <li>Быстрая работа тех. поддержки</li>
                  <li>Защита от DDoS-аттак и SSL шифрование данных</li>
                  <li>Партнёрская программа 7%-3%-1%</li>
                </ul>
                <a href="#"><br><br><br><br><br></a>
              </div>
            </div>
            <div id="blade-container">
              <img src="/bitrix/templates/stem/images/blade.png">
            </div>
          </div>
        </div>
      </div>
        <div id="main-container">
    <div id="main-content-wrap">
 
<div id="main-first"> 
<center><font color="#f2650a"><h2>Проект стартовал! Можете делать вклады!</h2></font></center>
  <div id="tariff-box"> 
    <div class="tariff"> 
      <div class="tariff-wrap"> 
        <div class="tariff-header"> 
          <div class="tariff-header-wrap"> 
            <p><a>Low</a></p>
           </div>
         </div>
       
        <ul> 
		<br>
          <li>Минимальный вклад $1</li>
		  
          <li>Максимальный вклад $150</li>  
		  
          <li>Вклад на 7 дней</li>
		  
          <li>Прибыль 134.4%</li>		  
		  <br><br>

<br />
         </ul>
       
        <div class="tariff-price-box"> 
          <div class="tariff-price"> 
            <div class="tariff-price-wrap"> 
              <p><span>0.8</span> %/час</p>
             </div>
           </div>
         <a href="/deposit/">Выбрать</a> </div>
       </div>
     </div>
   
    <div class="tariff"> 
      <div class="tariff-wrap"> 
        <div class="tariff-header"> 
          <div class="tariff-header-wrap"> 
            <p><a>Middle</a></p>
           </div>
         </div>
       
        <ul> 
		<br>
          <li>Минимальный вклад $151</li>
		  
          <li>Максимальный вклад $350</li>  
		  
          <li>Вклад на 7 дней</li>
		  
          <li>Прибыль 151.2%</li>			  
		  <br><br>
<br />
         </ul>
       
        <div class="tariff-price-box"> 
          <div class="tariff-price"> 
            <div class="tariff-price-wrap"> 
              <p><span>0.9</span> %/час</p>
             </div>
           </div>
         <a href="/deposit/" >Выбрать</a> </div>
       </div>
     </div>
   
    <div class="tariff"> 
      <div class="tariff-wrap"> 
        <div class="tariff-header"> 
          <div class="tariff-header-wrap"> 
            <p><a>High</a></p>
           </div>
         </div>
       
        <ul> 
		<br>
          <li>Минимальный вклад $351</li>
		  
          <li>Максимальный вклад $600</li>  
		  
          <li>Вклад на 7 дней</li>
		  
          <li>Прибыль 168%</li>			  
		  <br><br>
<br />
         </ul>
       
        <div class="tariff-price-box"> 
          <div class="tariff-price"> 
            <div class="tariff-price-wrap"> 
              <p><span>1</span> %/час</p>
             </div>
           </div>
         <a href="/deposit/" >Выбрать</a> </div>
       </div>
     </div>
   
    <div class="tariff"> 
      <div class="tariff-wrap"> 
        <div class="tariff-header"> 
          <div class="tariff-header-wrap"> 
            <p><a>VIP</a></p>
           </div>
         </div>
       <br>
        <ul> 
          <li>Минимальный вклад $100</li>
		  
          <li>Максимальный вклад $600</li>  
		  
          <li>Вклад на 4 дня</li>
		  
          <li>Прибыль 144%</li>			  
		  <br><br>
<br />
         </ul>
       
        <div class="tariff-price-box"> 
          <div class="tariff-price"> 
            <div class="tariff-price-wrap"> 
              <p><span>1.5</span> %/час</p>
             </div>
           </div>
         <a href="/deposit/" >Выбрать</a> </div>
       </div>
     </div>
   </div>
 
  <div id="news-box"> 
    <div id="news-right"> 
      <div id="news-right-wrap"> 
        <h2>О проекте</h2>
       
        <p>&nbsp;&nbsp;Здравствуйте дорогие друзья! Мы спешим вам представить новый проект HourlyPayment.org в 
		котором вы сможете каждый час выводить деньги из системы. Instant выплаты помогут вам убедиться в 
		честности данного проекта в целом.</p>
		
		<p>&nbsp;&nbsp;У нас работает хорошая команда которая всегда вам поможет в случае возникновения 
		проблемы, или же если у вас есть вопросы у нас установлена тех. поддержка которая 
		поможет вам практически в любое время суток.</p>
		
		<p>&nbsp;&nbsp;Мы сделали все возможное что бы этот проект был стабильным и 
		безопасным, поэтому мы установили защиту от DDoS-Guard.net, и SSL-шифрование данных от Comodo.</p>
       <br><br><br><br>
	   </div>
     </div>
   
    <div id="news-left"> 
      <div id="news-left-wrap"> 
        <div class="news-header"> 
          <h2>Новости</h2>
         <a href="/news" >Все новости</a> </div>
       
        <div class="news"> 
          <div class="news-date"> 16 сен. </div>
         <a>
		 
		 <?php
	$query	= "SELECT * FROM news ORDER BY id DESC LIMIT 1";
	$result	= mysql_query($query);
	$themes = mysql_num_rows($result);
while($row = mysql_fetch_array($result))
{
	print "".$row['msg']."";
				}
				?>
		 
		 
		 </a> </div>
       

       </div>
     </div>
   </div>
 
  <div id="after-news"> 

   </div>
 </div>
 
<br><br>
 
<div id="main-second"> 
  <div class="main-second-elem"> 
    <div class="fact-header"> 
      <p><strong>Стабильность</strong></p>
     </div>
   
    <div class="fact-img"> <img src="/ddos.png"  /> </div>
   
    <div class="fact"> 
      <p style="padding-left: 5px;"><br>На нашем сайте стоит защита от DDoS-аттак от ddos-guard.net.</p>
     </div>
   </div>
 
  <div class="main-second-elem"> 
    <div class="fact-header"> 
      <p><strong>SSL-шифрование</strong></p>
     </div>
   
    <div class="fact-img"> <img src="/comodo.png"  /> </div>
   
    <div class="fact"> 
      <p><br>На нашем сайте стоит Comodo PositiveSSL.</p>
     </div>
   </div>
 
  <div class="main-second-elem"> 
    <div class="fact-header"> 
      <p><strong>Опыт</strong></p>
     </div>
   
    <div class="fact-img"> <img src="/bitrix/templates/stem/images/monitor.png"  /> </div>
   
    <div class="fact"> 
      <p>Огромный опыт администрации и продуманные тарифные планы заставят проект долго держаться на плаву.</p>
     </div>
   </div>
 
  <div class="main-second-elem"> 
    <div class="fact-header"> 
      <p><strong>Реф. система</strong></p>
     </div>
   
    <div class="fact-img"> <img src="/bitrix/templates/stem/images/percent.png"  /> </div>
   
    <div class="fact"> 
      <p>С неплохой реферальной системой (7%-3%-1%) на нашем проекте можно зарабатывать ничего не вкладывая.</p>
     </div>
   </div>
 
  <div class="main-second-elem"> 
    <div class="fact-header"> 
      <p><strong>Тех. поддержка</strong></p>
     </div>
   
    <div class="fact-img"> <img src="/support.png"  /> </div>
   
    <div class="fact"> 
      <p>У Вас остались вопросы? Отзывчивая тех. поддежка поможет Вам их решить в кротчайшие сроки.</p>
     </div>
   </div>
 </div>
 
     </div>
    </div><!-- #main-container end -->
		<? include ("includes/foot.php"); ?>