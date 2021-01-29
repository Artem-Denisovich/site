<?
echo <<<DATA
<html>
<head>
<title>ExBB Administration</title>
<meta http-equiv="Content-Type" content="text/html;">
<link rel="stylesheet" href="./templates/subSilver/subSilver.css" type="text/css"> 
</head>

<frameset cols="170,*" rows="*" border="2" framespacing="0" frameborder="yes"> 
  <frame src="admincenter.php?action=navbar" name="nav" marginwidth="3" marginheight="3" scrolling="auto">
  <frame src="admincenter.php?action=main" name="main" marginwidth="10" marginheight="10" scrolling="auto">
</frameset>

<noframes>
	<body bgcolor="#FFFFFF" text="#000000">
		<p>Sorry, your browser doesn't seem to support frames</p>
	</body>
</noframes>
</html>
DATA;
?>