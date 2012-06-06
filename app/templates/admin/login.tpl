<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    {*{assign_from_registry key='adminTitle' var='adminTitle'}*}
		<title>{$adminTitle}</title>
    {*{assign_from_registry key='favicon' var='favicon'}*}
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

		{*                       CSS                       *}

		{* Reset Stylesheet *}
		<link rel="stylesheet" href="/script/admin/css/reset.css" type="text/css" media="screen" />

		{* Main Stylesheet *}
		<link rel="stylesheet" href="/script/admin/css/style.css" type="text/css" media="screen" />

		{* Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid *}
		<link rel="stylesheet" href="/script/admin/css/invalid.css" type="text/css" media="screen" />

		<!-- Colour Schemes

		Default colour scheme is green. Uncomment prefered stylesheet to use it.

		<link rel="stylesheet" href="/script/admin/css/blue.css" type="text/css" media="screen" />

		<link rel="stylesheet" href="/script/admin/css/red.css" type="text/css" media="screen" />

		-->

		{* Internet Explorer Fixes Stylesheet *}

		<!--[if lte IE 7]>
			<link rel="stylesheet" href="/script/admin/css/ie.css" type="text/css" media="screen" />
		<![endif]-->

		{*                       Javascripts                       *}

		{* jQuery *}
		<script type="text/javascript" src="/script/jquery-1.4.2.min.js"></script>

		{* jQuery Configuration *}
		<script type="text/javascript" src="/script/admin/scripts/simpla.jquery.configuration.js"></script>

		{* Facebox jQuery Plugin *}
		<script type="text/javascript" src="/script/admin/scripts/facebox.js"></script>

		{* jQuery WYSIWYG Plugin *}
		<script type="text/javascript" src="/script/admin/scripts/jquery.wysiwyg.js"></script>

		{* Internet Explorer .png-fix *}

		<!--[if IE 6]>
			<script type="text/javascript" src="/script/admin/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">
				DD_belatedPNG.fix('.png_bg, img, li');
			</script>
		<![endif]-->

	</head>

	<body id="login">

		<div id="login-wrapper" class="png_bg">
			<div id="login-top">

      {*{assign_from_registry key='adminLogo' var='logo'}*}

				<h1>1100AD</h1>
        {$logo}
				{* Logo (221px width) *}
				{*<img id="logo" src="/script/admin/images/logo.png" alt="Simpla Admin logo" />*}
			</div> {* End #logn-top *}

			<div id="login-content">

				<form action="{$LURL}/admin/login" method="post">

{*					<div class="notification information png_bg">
						<div>
							Just click "Sign In". No password needed.
						</div>
					</div>*}

					<p>
						<label>Username</label>
						<input class="text-input" type="text" id="usr" name="usr" />
					</p>
					<div class="clear"></div>
					<p>
						<label>Password</label>
						<input class="text-input" type="password" name="pwd" />
					</p>
					<div class="clear"></div>
					{*<p id="remember-password">
						<input type="checkbox" />Remember me
					</p>
					<div class="clear"></div>*}
					<p>
						<input class="button" type="submit" value="Sign In" />
					</p>
					<input type="hidden" name="ss" value="{$segments}">
				</form>
			</div> {* End #login-content *}

		</div> {* End #login-wrapper *}

  </body>

{literal}
<script type="text/javascript">$(function() {$('#usr').focus();})</script>
{/literal}
</html>
