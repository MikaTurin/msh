<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {*{assign_from_registry key='adminTitle' var='adminTitle'}*}
		<title>{$adminTitle}</title>
    {*{assign_from_registry key='favicon' var='favicon'}*}
    <link rel="shortcut icon" href="{$favicon}" type="image/x-icon">

		{* Reset Stylesheet *}
		<link rel="stylesheet" href="/script/admin/css/reset.css" type="text/css" media="screen">

		{* Main Stylesheet *}
		<link rel="stylesheet" href="/script/admin/css/style.css" type="text/css" media="screen">

		{* Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid *}
		<link rel="stylesheet" href="/script/admin/css/invalid.css" type="text/css" media="screen">

		{*<link rel="stylesheet" href="/script/admin/css/red.css" type="text/css" media="screen" />*}

		{* Colour Schemes

		Default colour scheme is green. Uncomment prefered stylesheet to use it.

		<link rel="stylesheet" href="/script/admin/css/blue.css" type="text/css" media="screen" />

		<link rel="stylesheet" href="/script/admin/css/red.css" type="text/css" media="screen" />

        *}

		{* Internet Explorer Fixes Stylesheet *}

		<!--[if lte IE 7]>
			<link rel="stylesheet" href="/script/admin/css/ie.css" type="text/css" media="screen" />
		<![endif]-->

		{* jQuery *}
		<script src="/script/jquery-1.6.3.min.js" type="text/javascript"></script>
    <script src="/script/admin/scripts/jquery.address-1.4.min.js" type="text/javascript"></script>
    <script src="/script/jquery.qtip-1.0.0-rc3.min.js" type="text/javascript"></script>
    <script src="/script/jquery.tezutils.js" type="text/javascript"></script>
    <script src="/script/admin/scripts/admin.area.js" type="text/javascript"></script>

		{* jQuery Configuration *}
		<script type="text/javascript" src="/script/admin/scripts/simpla.jquery.configuration.js"></script>

		{* Facebox jQuery Plugin *}
		<script type="text/javascript" src="/script/admin/scripts/facebox.js"></script>

		{* jQuery WYSIWYG Plugin *}
		<script type="text/javascript" src="/script/admin/scripts/jquery.wysiwyg.js"></script>

		{* jQuery Datepicker Plugin *}
		{*<script type="text/javascript" src="/script/admin/scripts/jquery.datePicker.js"></script>
		<script type="text/javascript" src="/script/admin/scripts/jquery.date.js"></script>*}
		<!--[if IE]><script type="text/javascript" src="/script/admin/scripts/jquery.bgiframe.js"></script><![endif]-->


		{* Internet Explorer .png-fix *}

		<!--[if IE 6]>
			<script type="text/javascript" src="/script/admin/scripts/DD_belatedPNG_0.0.7a.js"></script>
			<script type="text/javascript">DD_belatedPNG.fix('.png_bg, img, li');</script>
		<![endif]-->

    {block name='head'}{/block}
	</head>

	<body><div id="body-wrapper"> {* Wrapper for the radial gradient background *}

		<div id="sidebar"><div id="sidebar-wrapper"> {* Sidebar with logo and menu *}

      {*{assign_from_registry key='adminLogo' var='logo'}*}
      <div style="margin:20px 0 20px 10px" align="center">{$logo}</div>
			{*<h1 id="sidebar-title"></h1>*}

			{* Logo (221px wide) *}
			{*<a href="#"><img id="logo" src="/script/admin/images/logo.png" alt="Simpla Admin logo" /></a>*}

			{* Sidebar Profile links *}
			<div id="profile-links">
				Hello, <a href="#" title="Edit your profile">{$adminUserName}</a>{*, you have <a href="#messages" rel="modal" title="3 Messages">3 Messages</a>*}
        <br>
				<a href="/" title="View the Site">View the Site</a> | <a href="{$LURL}/auth/logout" title="Sign Out">Sign Out</a>
			</div>

      {* Accordion Menu Start *}
      {*{assign_from_registry key='adminMenu' var='menu'}*}
      <ul id="main-nav">

        {foreach $menu as $url => $r}
        <li>

          {assign var='is' value='0'}
          {if $CNTRL eq $url || (!$url && $CNTRL eq 'index')}{assign var='is' value='1'}{assign var='lvl1' value=$url}{/if}

          <a href="{if $r.url}{$r.url}{else}{if $r.submenu}#{else}{$LURL}/admin/{$url}{/if}{/if}"
             class="nav-top-item{if !$r.submenu} no-submenu{/if}{if $is} current{/if}">{$r.name}</a>

          {if $r.submenu}<ul>{/if}
          {foreach $r.submenu as $url2 => $rr}
            <li><a href="{if $rr.url}{$rr.url}{else}{$LURL}/admin/{$url}{if $url2}/{$url2}{/if}{/if}"
              {if $is && ($ACTN eq $url2 || ($ACTN eq $CNTRL && !$url2))}{assign var='lvl2' value=$url2} class="current"{/if}>{$rr.name}</a></li>
          {/foreach}
          {if $r.submenu}</ul>{/if}
        </li>
        {/foreach}

      </ul>
      {* Accordion Menu End *}

		</div></div> {* End #sidebar *}

		<div id="main-content"> {* Main Content Section with everything *}

			<noscript> {* Show a notification if the user has disabled javascript *}
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>

			{* Page Head *}
      {if !$hideTitle}
			<h2>{if $menu[$lvl1].title}{$menu[$lvl1].title}{else}{$menu[$lvl1].name}{/if}{if {$menu[$lvl1].submenu[$lvl2].name}} / {$menu[$lvl1].submenu[$lvl2].name}{/if}</h2>
      {/if}

      <div class="clear"></div>

      {block name='content'}{$content}{/block}


			<div id="footer">
				<small> {* Remove this notice or replace it with whatever you want *}
						&#169; Copyright 2011 Teztour | Template by {*<a href="http://themeforest.net/item/simpla-admin-flexible-user-friendly-admin-skin/46073">*}Simpla Admin{*</a>*} | <a href="#">Top</a>
				</small>
			</div>{* End #footer *}

		</div> {* End #main-content *}

	</div></body>

</html>
