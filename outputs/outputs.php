<!-- Breadcrumbs Begin -->
				<div class="general-block-outer">
					<div class="general-block breadcrumbs">
						<ul class="breadcrumbs">
							<li class="home"><a href="#"><img src="../images/green/breadcrumbs_home.png" border="0"/></a></li>
							<li><a href="#">Выплаты проекта</a></li>
							
						</ul>
						<br class="clear"/>
					</div>
				</div>
				<!-- Breadcrumbs End -->
<?php
function topics_list2($page, $num, $query)
{
?>

<div class="general-block-outer">
					<div class="general-block cart-container">
						<table cellpadding="0" cellspacing="0">
						<tr>
								<td class="remove"><span class="heading">#</span></td>
								<td style="width:200px" class="product-name"><span class="heading">Дата</span></td>
								
								<td style="width:250px" class="product-name"><span class="heading">Логин</span></td>
								<td style="width:250px" class="product-name"><span class="heading">Сумма</span></td>
								<td style="width:250px" class="product-name"><span class="heading">Система</span></td>
								
							</tr>

<?php
	$result = mysql_query($query.' LIMIT 10');
	while ($topics = mysql_fetch_array($result))
	{

		print '<tr>
								<td class=\"remove\">#</td>
								<td style=\"width:200px\" class=\"product-name\">'.date("d.m.Y H:i:s", $topics['date']).'</td>
								<td style=\"width:550px\" class=\"product-name\">'.$topics['login'].'</td>
								<td style=\"width:550px\" class=\"product-name\">'.$topics['sum'].'</td>
								<td style=\"width:550px\" class=\"product-name\">';
								if($topics['paysys'] == 1) { print "PerfectMoney"; } else { print "LibertyReserve"; }print'
								</td>
								
								
							</tr>';

	}
?>
</table>
					</div>
				</div>
<?php
}

$sql = 'SELECT * FROM output WHERE status = 2 ORDER BY id DESC';

topics_list2(1, 10, $sql);

?>