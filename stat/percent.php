<?php
defined('ACCESS') or die();
?>
<div class="general-block-outer">
					<div class="general-block cart-container">
												<center><font color="#f2650a"><h2>Начисление процентов</h2></font></center>
							<br>
						<table cellpadding="0" cellspacing="0">
						<tr>
								<td class="remove"><span class="heading">#</span></td>
								<td style="width:200px" class="product-name"><span class="heading">Дата</span></td>
								
								<td style="width:250px" class="product-name"><span class="heading">Сумма</span></td>
								
							</tr>
<?php

	$sql	= 'SELECT * FROM stat WHERE user_id = '.$user_id.' order by id DESC';
	$rs		= mysql_query($sql);
	if(mysql_num_rows($rs)) {

		while($a = mysql_fetch_array($rs)) {
				print "<tr>
								<td class=\"remove\">#</td>
								<td style=\"width:200px\" class=\"product-name\">".date("d.m.Y H:i", $a['date'])."</td>
								<td style=\"width:550px\" class=\"product-name\">".$a['sum']."</td>
								
								
							</tr>";
		}

	} else {
		print "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"center\">Нет данных!</td></tr>";
	}
print "</table></div>
				</div>";