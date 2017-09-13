
			
<div id="menu">
	<ul>
		<li><a href="/" class="current"><span>Главная</span></a></li>
				<?php
if(!$login) {
?>
				<li><a href="/auth/#toregister">Регистрация</a></li>
				<li><a href="/auth/#tologin">Вход</a></li>	
				<?php
} else {
?>
<li><a href="/deposit">Открыть вклад</a></li>
<li><a href="/enter/">Пополнить баланс</a></li>
<li><a href="/withdrawal/">Вывести средства</a></li>						
	
<?
}
?>	
				<li><a href="/news/">Новости</a></li>
				<li><a href="/contacts">Контакты</a></li>
</ul>
</div>			
