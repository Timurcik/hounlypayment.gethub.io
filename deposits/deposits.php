

<?php
defined('ACCESS') or die();
if($login) {
?>
	
						
<?php
$s = 0;
$result	= mysql_query("SELECT * FROM deposits WHERE user_id = ".$user_id." ORDER BY id ASC");
while($row = mysql_fetch_array($result)) {

	$result2	= mysql_query("SELECT * FROM plans WHERE id = ".$row['plan']." LIMIT 1");
	$row2		= mysql_fetch_array($result2);

print "<div class=\"general-block-outer\">
					<div class=\"general-block cart-container\">
																	<center><font color=\"#f2650a\"><h2>Вклады</h2></font></center>
							<br>					
						<table cellpadding=\"0\" cellspacing=\"0\">


<tr>
								<td class=\"remove\"><span class=\"heading\">#</span></td>
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Сумма</span></td>
								
								<td style=\"width:250px\" class=\"product-name\"><span class=\"heading\">Процент</span></td>
								
								
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Период зачисления</span></td>
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Срок</span></td>
								<td style=\"width:200px\" class=\"product-name\"><span class=\"heading\">Дата открытия</span></td>
							</tr>




<tr>
								<td class=\"remove\">#</td>
								<td style=\"width:200px\" class=\"product-name\">".$row['sum']."</td>
								<td style=\"width:550px\" class=\"product-name\">".$row2['percent']."%</td>
								
								<td style=\"width:200px\" class=\"product-name\">в ";
								if($row2['period'] == 1) { print "день"; } elseif($row2['period'] == 2) { print "неделю"; }  elseif($row2['period'] == 4) { print "час"; } else { print "месяц"; }
								print"</td>
								<td style=\"width:200px\" class=\"product-name\"> на ".$row2['days'];
								if($row2['period'] == 4) { print " часов"; } elseif($row2['period'] == 1) { print " дней"; } elseif($row2['period'] == 2) { print " недель"; } elseif($row2['period'] == 3) { print " месяцев"; }
								print"</td>
								<td style=\"width:200px\" class=\"product-name\">".date("d.m.Y H:i", $row['date'])."</td>
							</tr>
";

if(cfgSET('autopercent') == "on") {
print "<table style=\"width:100%\">
<tr>
	<td align=\"center\"><b>Следующее зачисление процентов: <span id=\"deptimer".$row['id']."\"></span></b> [ ".date("H:i d.m.Y", $row['nextdate'])." ]</td>
</tr>
<tr>


                    
                  
	
	

					
		
		<script language=\"JavaScript\">
		<!--
			CalcTimePercent(".$row['id'].", ".$row['lastdate'].", ".$row['nextdate'].", ".time().", ".$row2['period'].");
		//-->
		</script>

</tr>

</table>
					</div>
				</div>";
}


$s = $s + $row['sum'];
}
?>
		<div class="general-block-outer">
					<div class="general-block cart-container">

						<table style=\"height:50px\" cellpadding="0" cellspacing="0">			
<?php 

	if($s == 0) {
		print '<p class="er"><center>У вас нет открытых депозитов</center></p></table>
					</div>
				</div>';
	} else {
		print '<center>Всего открытых депозитов на сумму <b>$'.$s.'</b></center>
		
		</table>
					</div>
				</div>';
	}

} else {
	print "<p class=\"er\">Для доступа к данной странице вам необходимо авторизироваться</p>";
}
?>