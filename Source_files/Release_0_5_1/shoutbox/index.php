<?php
	include "config.php"; 
	include "functions.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php echo $adminname; ?> - Palmnet Shoutbox</title>
	<link href="design/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo geturldir(); ?>rss.php" rel="alternate" type="application/rss+xml" title="<?php echo $adminname; ?>'s shoutbox RSS feed" />
	<script language="javascript" type="text/javascript">
		if(top!=self)
		{
			top.location.href=self.location.href;
		}
	</script>
	<!-- Original design by PWnet | www.pwnet.org.uk | October 2006 -->
	<!-- Shoutbox by Palmnet | www.palmnet.me.uk | October 2006 -->
	<!-- Shoutbox version 0.5 -->
</head>
<body>
	<div id="page">
		<div id="header">
			<div id="text">
				<h1><?php echo $adminname; ?>'s Shoutbox</h1>
			</div>
			<div id="menu">
				<a href="index.php">Refresh</a> | <a href="http://code.google.com/p/freepss/">Get your own</a>
			</div>
			<div id="content">
<?php include"post.php"; ?>
			</div>
		</div>
		<div id="footer">
			<img src="design/credits.jpg" alt="Palmnet &amp; PWnet" usemap="#Map" align="right" border="0" height="96" width="288" />
			<map name="Map" id="Map">
				<area shape="rect" coords="54,22,143,56" href="http://www.palmnet.me.uk/" alt="Palmnet" title="Palmnet" />
				<area shape="rect" coords="152,17,230,66" href="http://www.pwnet.org.uk/" alt="PWnet" title="PWnet" />
				<area shape="rect" coords="1,23,37,60" href="rss.php" alt="RSS 2.0" title="RSS 2.0"/>
			</map>
			<p class="copy">© 2006 Nick Palmer &amp; Phil Wylie. All rights reserved.</p>
		</div>
	</div>
</body>
</html>