{* ____________________________________________________________
|                                                            |
|    DESIGN + Pat Heard { http://fullahead.org }             |
|      DATE + 2006.09.12                                     |
| COPYRIGHT + Free use if this notice is kept in place.
| VERSION 2 + Sean Pollock ( http://sean-pollock.com)
|      DATE + 2008.04.22
| COPYRIGHT + Creative Commons Attribution 2.0,
|             Link to sean-pollock.com MUST BE KEPT
|             Does not allow removal of FullAhead Link!
|____________________________________________________________|
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Simple Life 2.0 - By Fullahead and Sean Pollock</title>
  <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <link rel="stylesheet" type="text/css" href="/script/html.css" media="screen, projection, tv " />
  <link rel="stylesheet" type="text/css" href="/script/layout.css" media="screen, projection, tv" />
  <link rel="stylesheet" type="text/css" href="/script/print.css" media="print" />
  {*Conditional comment to apply opacity fix for IE #content background.
       Invalid CSS, but can be removed without harming design*}
  <!--[if gt IE 5]>
  <link rel="stylesheet" type="text/css" href="css/ie.css" media="screen, projection, tv " />
  <![endif]-->
  <script type="text/javascript" src="/script/jquery-1.6.4.min.js"></script>
  {if $isadmin}
  <script type="text/javascript">var LURL='{$LURL}';</script>
  <script src="/script/mercury/javascripts/mercury_loader.js" type="text/javascript"></script>
  {*<script src="/script/admin.js" type="text/javascript"></script>*}
  {/if}
  {block name=head}{/block}
</head>

<body>
{* #wrapper: centers the content and sets the width *}
<div id="wrapper">
  {* #content: applies the white, dropshadow background *}
  <div id="content">
    {* #header: holds site title and subtitle *}
    <div id="header">
      <h1>{lang:main_title}</h1>
      <h2><span class="highlight">MSH project concept (ver 0.1) by <a href="mailto:mika.turin at gmail.com">Mika Turin</a></span></h2>
    </div>
    {* #menu: topbar menu of the site.  Use the helper classes .two, .three, .four and .five to set
                the widths for 2, 3, 4 and 5 item menus. *}
    <ul id="menu" class="four">
      <li><a href="{$LURL}" title="An intro to Simple Life"{if $page eq 'index'} class="here"{/if}><span class="big">I</span>ntro</a></li>
      <li><a href="{$LURL}/coding" title="Coding tips"{if $page eq 'coding'} class="here"{/if}><span class="big">C</span>oding</a></li>
      <li><a href="{$LURL}/styles" title="See the tags in action"{if $page eq 'styles'} class="here"{/if}><span class="big">S</span>tyles</a></li>
      <li><a href="{$LURL}/contact" title="Get in touch"{if $page eq 'contact'} class="here"{/if}><span class="big">C</span>ontact</a></li>
    </ul>
    {* #page: holds all page content, as well as footer *}
    <div id="page">
      {block name=page}{/block}
      <p class="footer">


        {* DO NOT REMOVE *}
        Design by <a href="http://fullahead.org" title="Visit FullAhead">FullAhead</a> + <a href="http://sean-pollock.com">Sean Pollock</a> |
        {*^ DO NOT REMOVE ^*}


        Copyright&copy; 2010 YourWebSite.com.      </p>
    </div>
  </div>
</div>

{if !$isadmin}
<div class="go" style="position:fixed; top:20px; right:40px; width:48px; height:48px; background:url('/script/mercury/img/admin.png') no-repeat" onclick="{literal}$.ajax({type:'POST', url:'/admin/editor', success:function(){top.location.reload();}});{/literal}"></div>
{/if}

</body>
</html>