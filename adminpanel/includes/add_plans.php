


<script language="JavaScript">
<!--
	function checkPeriod() {
		if(document.getElementById('period').value == '4') {
			document.getElementById("srok").innerHTML = "часов"
		} else if(document.getElementById('period').value == '1') {
			document.getElementById("srok").innerHTML = "дней"
		} else if(document.getElementById('period').value == '2') {
			document.getElementById("srok").innerHTML = "недель"
		} else if(document.getElementById('period').value == '3') {
			document.getElementById("srok").innerHTML = "месяцев"
		}
	}
//-->
</script>
     










<form action="?a=plans&action=add" method="post"><br>
		   <label class="field-name">Название:</label>
            <input type="text" name="name" placeholder="Название">

            <label class="field-name">Минимальная сумма вклада:</label>
            <input type="text" name="minsum" placeholder="MIN Summa">

            <label class="field-name">Максимальная сумма вклада:</label>
            <input type="text" name="maxsum" placeholder="MAX Summa">
			
			
			
			<label class="field-name">Бонус к сумме депозита (%):</label>
            <input type="text" name="bonusdeposit" placeholder="Бонус к депозиту">

            <label class="field-name">Бонус на баланс от депо.(%):</label>
            <input type="text" name="bonusbalance" placeholder="Бонус на счет от депозита">
			
			<label class="field-name">Период:</label>
            <div class="form-row">
                  
                  <div class="field noSearch">
                    <select class="uniform" name="period" id="period" onChange="checkPeriod();">
                      <option>Выберите срок</option>
                      <option value="4">В час</option>
                      <option value="1">В день</option>
                      <option value="2">В неделю</option>
                      <option value="3">В месяц</option>
                    </select>
                  </div>
                </div>
			
			 <label class="field-name">Срок (<span id="srok">дней</span>):</label>
            <input type="text" name="days" placeholder="Срок">
			
			 <label class="field-name">Процент:</label>
            <input type="text" name="percent" placeholder="Процент">
			
			
			

				
				
				
				<label class="field-name">Возврат вклада вконце срока:</label>
            <div class="form-row">
                  
                  <div class="field noSearch">
                    <select class="uniform" name="back">
                      <option>Выбор</option>
                      <option value="1">ДА</option>
                      <option value="0">НЕТ</option>

                    </select>
                  </div>
                </div>
				
	

            <div class="row-fluid">
              <div class="actions">
                <span class="span6">
                  <input type="submit" name="submit" value="Добавить" class="button button-blue small-button">
                </span>
                <span class="span6">
                  
                </span>
              </div>
            </div>
			</form>