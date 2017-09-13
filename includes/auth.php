<?php
if(!$login) {
?>
	<table align="center" cellpadding="1" cellspacing="0">
	<form action="/login/" method="post">
	<tr>
		<td style="padding-left: 2px;">Login</td>
		<td style="padding-left: 2px;">Password</td>
	</tr>
	<tr>
		<td><input type="text" name="user" size="13"></td>
		<td><input type="password" name="pass" size="13"></td>
	</tr>
	<tr>
		<td style="padding-left: 2px;"><a href="/registration/">Sign Up</a><br /><a href="/reminder/">Forgot password?</a></td>
		<td align="right"><input style="border: none;" type="image" src="/images/enter.gif" title="Sig in" /></td>
	</tr>
	</form>
	</table>
	<hr />
<?php
} else {
    print "<div class=\"moduletable-spy\"><p align=\"center\"><b>Welcome <b style=\"color: green\">".$login."</b>!</b><br /> Your balance: $<b>".$balance."</b></p>";
	print '<ul>';
	if($status == 1) {
		print '<li><a href="/adminpanel/"><img src="/images/admin.png"</a></li>';
	}
	print '<li><a href="/deposit/"><img src="/images/otdepo_en.png"</a></li>';
	print '<li><a href="/deposits/"><img src="/images/vashidepo_en.png"</a></li>';
	print '<li><a href="/enter/"><img src="/images/pbalans_en.png"</a></li>';
	print '<li><a href="/withdrawal/"><img src="/images/sredstva_en.png"</a></li>';
	print '<li><a href="/ref/"><img src="/images/refka_en.png"</a></li>';
	print '<li><a href="/stat/"><img src="/images/stata_en.png"</a></li>';
        print '<li><a href="/outputs/"><img src="/images/viplotiproekta_en.png"</a></li>';
	print '<li><a href="/profile/"><img src="/images/profil_en.png"</a></li>';
	print '<li><a href="/exit.php/"><img src="/images/vihod_en.png"</a></li>';
        print '<li><a href="/exit_en.php/"></a></li>';
        print '</ul></div>';
}
?>