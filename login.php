
//<?php
//session_destroy();
//?>


<html>

  <style type="text/css">
   BODY {background-repeat:no-repeat;
　　　　 background-position:100% auto;
		 background-image:url(wallpaper-1170561.jpg);
		}
.pos { position:absolute;top:250px; left:0%; }
.signin { position:relative;top:250px; }
.top { position:absolute;margin: 0 auto;font-size: 300%; color:white;}

img.bg {
  /* Set rules to fill background */
  min-height: 100%;
  min-width: 1024px;
  /* Set up proportionate scaling */
  width: 100%;
  height: auto;
  /* Set up positioning */
  position: fixed;
  /* またはabsolute; */
  top: 0;
  left: 0;
}

@media screen and (max-width: 1024px){
  img.bg {left: 50%; margin-left: -512px; }
}
div#container { position: relative;}

H1{color: white;}

H2{color: white;}



  </style>


	<head>
		<title>ログイン</title>
	</head>

<body>
<img class="bg" src="haikei2.png" alt="" />
<div id="container">

<SPAN class="top">
Gridster
</SPAN>
<div id="signin" class="signin" align="right" >
	<form method="POST" action="./gridstr.php" >
	<table >
		<tr>
			<td>
				<td  style="padding: 13px 0px 0px 0px;">
				<h2>name:</h2>
			</td>
			<td>
				<input type="text" name="name" size="40">
			</td>
		</tr>
		<tr>
			<td>
				<td  style="padding: 13px 0px 0px 0px;">
				<h2>pass:</h2>
			</td>
			<td>
				<input type="password" name="pass" size="40">
			</td>
		</tr>
	</table>
		<h2><input type="submit" value="sign in" style="background-color:white;color:blue;"></h2>
	</form>
</div>
<br><br><br>

<div  id="pos" class="pos" align=left>
	<form method="POST" action="./entry.php">
	<table>
		<tr>
			<td>
				<td  style="padding: 13px 0px 0px 0px;">
				<h2>name:</h2>
			</td>
			<td>
				<input type="text" name="name" size="40">
			</td>
		</tr>
		<tr>
			<td>
				<td  style="padding: 13px 0px 0px 0px;">
				<h2>pass:</h2>
			</td>
			<td>
				<input type="password" name="pass" size="40">
			</td>
		</tr>
		<tr>
			<td>
				<td  style="padding: 13px 0px 0px 0px;">
				<h2>mail:</h2>
			</td>
			<td>
				<input type="text" name="mail" size="40">
			</td>
		</tr>
	</table>
		<h2><input type="submit" value="sign up" style="background-color:#0088ff ;color:white;"></h2>
	</form>
</div>
</div>
</body>


</html>
		