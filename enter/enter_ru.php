<?php
defined('ACCESS') or die();
if ($login) {

	if ($_GET['action'] == 'save') {
		$sum	= sprintf ("%01.2f", str_replace(',', '.', $_POST['sum']));
		$ps		= intval($_POST['ps']);

		if ($sum <= 0) {
			print '<p class="er">������� ���������� ����� (�� $0.10 �� $1000)!</p>';
		} elseif ($sum < 0.10 || $sum > 1000) {
			print '<p class="er">�� ���� ��� ��������� �������� �� $0.10 �� $1000!</p>';
		} elseif($ps < 1 || $ps > 2) {
			print '<p class="er">������� ��������� �������!</p>';
		} else {

				// ����� ����������
					if($ps == 1) {

					// PM

					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "PM", "bal")';
					mysql_query($sql);

					print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
					<LEGEND><b>������������� �������</b></LEGEND>
					<form action="https://perfectmoney.com/api/step1.asp" method="POST">
					<input type="hidden" name="PAYEE_ACCOUNT" value="'.$cfgPerfect.'">
					<input type="hidden" name="PAYEE_NAME" value="'.$cfgPAYEE_NAME.'">
					<input type="hidden" name="PAYMENT_ID" value="'.mysql_insert_id().'">
					<input type="hidden" name="PAYMENT_AMOUNT" value="'.$sum.'">
					<input type="hidden" name="PAYMENT_UNITS" value="USD">
					<input type="hidden" name="STATUS_URL" value="https://www.pro-bizness.com/pmresult.php">
					<input type="hidden" name="PAYMENT_URL" value="http://'.$cfgURL.'/?pay=yes">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="http://'.$cfgURL.'/enter/?er=1">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="BAGGAGE_FIELDS" value="">
					<input type="hidden" name="SUGGESTED_MEMO" value="'.$cfgURL.'">
					<center>
					�� ���������� <strong>'.$sum.'</strong> USD �� ���� <strong>'.$cfgPerfect.'</strong> PerfectMoney<br />���������� ������� � ������� '.$cfgURL.'<br />
					<p align="center"><input class="subm" name="PAYMENT_METHOD" type="submit" value=" ����� ����������� " /></p>
					</center>
					</form>
					</FIELDSET>';

					
					} elseif($ps == 2) {

					// LR

					$sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "LR", "bal")';
						if(mysql_query($sql)) {

					print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
					<LEGEND><b>������������� �������</b></LEGEND>
					<form method="post" action="https://sci.libertyreserve.com">
					<input type="hidden" name="lr_acc" value="'.$cfgLiberty.'">
					<input type="hidden" name="lr_store" value="'.$cfgPAYEE_NAME.'">
					<input type="hidden" name="lr_amnt" value="'.$sum.'">
					<input type="hidden" name="lr_currency" value="LRUSD">
					<input type="hidden" name="lr_comments" value="'.$cfgURL.'">
					<input type="hidden" name="item_name" value="'.mysql_insert_id().'">
					<center>
					�� ���������� <strong>'.$sum.'</strong> USD �� ���� <strong>'.$cfgLiberty.'</strong> LibertyReserve<br />���������� ������� � ������� '.$cfgURL.'<br />
					<p align="center"><input class="subm" type="submit" value=" ����� ����������� " /></p>
					</center>
					</form>
					</FIELDSET>';

						} else {
							print '<p class="er">�� ������ ��������� ������!</p>';
						}

				
					}
		}
	} else {
	?>
         <b>���� �� ������� ��������� ���� ������ ����� Qiwi,���������� �������� ������� �� ������� ������ �������.� ����������� ��������:"���� ����� � �������� ����".������ ����� ��������� �� ��� ������ � ��������� �����.</b>
        <h1>������ �������: +79803178410</h1>
	<h1>����: 31 ����� =1$</h1>
	<table align="center">
	<form action="?action=save" method="post">
	<tr><td><b>����� �����</b>: </td><td align="right"><input style="width: 180px;" type='text' name='sum' value='' size="30" maxlength="7" /></td></tr>
	<tr><td><b>��������� �������</b>: </td><td align="right">
	<select style="width: 180px; margin-right: 0px;" name="ps">
		<?php if($cfgPerfect) { ?><option value="1">PerfectMoney</option> <?php } ?>
		<?php if($cfgLiberty) { ?><option value="2">LibertyReserve</option> <?php } ?>
	</select></td></tr>
	<tr><td></td><td align="right"><input class="subm" type='submit' name='submit' value=' ��������� ������ ' /></td></tr>
	</form>
	</table>
        <?php
	}

} else {
	print "<p class=\"er\">�� ������ ���������������� ��� ������� � ���� ��������!</p>";
}

?>