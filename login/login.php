<p class="er">Invalid username or password!</p>
<div align="center">
<form method="post" action="/login/">
	<p><input type="text" name="user" style="width: 150px;" onblur="if (value == '') {value='Login'}" onfocus="if (value == 'Login') {value =''}" value="Login" /> <input type="password" name="pass" style="width: 150px;" onblur="if (value == '') {value='password'}" onfocus="if (value == 'password') {value =''}" value="password" /> <input class="subm" type="submit" value=" Sign in! " /></p>
	<p><a href="/registration/">Sign Up</a> || <a href="/reminder/">Forgot password?</a></p>
</form>
</div>