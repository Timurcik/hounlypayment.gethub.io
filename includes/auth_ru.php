<?php
if(!$login) {
?>
	<table align="center" cellpadding="1" cellspacing="0">
	<form action="/login/" method="post">
	<tr>
		<td style="padding-left: 2px;">Логин</td>
		<td style="padding-left: 2px;">Пароль</td>
	</tr>
	<tr>
		<td><input type="text" name="user" size="13"></td>
		<td><input type="password" name="pass" size="13"></td>
	</tr>
	<tr>
		<td style="padding-left: 2px;"><a href="/registration/">Регистрация</a><br /><a href="/reminder/">Забыли пароль?</a></td>
		<td align="right"><input style="border: none;" type="image" src="/images/enter.gif" title="Войти" /></td>
	</tr>
	</form>
	</table>
	<hr />
<?php
} else {
    print "<div class=\"moduletable-spy\"><p align=\"center\"><b>Добро пожаловать <b style=\"color: green\">".$login."</b>!</b><br /> Баланс: $<b>".$balance."</b></p>";
	print '<ul>';
	if($status == 1) {
		print '<li><a href="/adminpanel/"><img src="/images/admin.png"</a></li>';
	}
	print '<li><a href="/deposit/"><img src="/images/otdepo.png"</a></li>';
	print '<li><a href="/deposits/"><img src="/images/vashidepo.png"</a></li>';
	print '<li><a href="/enter/"><img src="/images/pbalans.png"</a></li>';
	print '<li><a href="/withdrawal/"><img src="/images/sredstva.png"</a></li>';
	print '<li><a href="/ref/"><img src="/images/refka.png"</a></li>';
	print '<li><a href="/stat/"><img src="/images/stata.png"</a></li>';
        print '<li><a href="/outputs/"><img src="/images/viplotiproekta.png"</a></li>';
	print '<li><a href="/profile/"><img src="/images/profil.png"</a></li>';
	print '<li><a href="/exit.php/"><img src="/images/vihod.png"</a></li>';
        print '<li><a href="/exit.php/"></a></li>';
        print '</ul></div>';
}
?>