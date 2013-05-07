<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<META http-equiv="Content-Style-Type" content="text/css">
	<link rel="stylesheet" type="text/css" href="dist/jquery.gridster.css">
	<link rel="stylesheet" type="text/css" href="libs/jquery/jquery-ui.css">
	<script type="text/javascript" src="libs/jquery/jquery.js"></script>
	<script type="text/javascript" src="dist/jquery.gridster.js"></script>
	<script type="text/javascript" src="libs/jquery/jquery-ui.js"></script>



  <style type="text/css">
   BODY {background-repeat:no-repeat;
　　　　 background-position:100% auto;
		}

/* CSS部分*/

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
  img.bg {
  left: 50%;
  margin-left: -512px; }
}
div#container {
  position: relative;
}


div#content {
  position: absolute;
  right:0;
  color:white;
  font-size:20px;
font-weight:bold;
}


a {
text-decoration: none;
}

.logout{ position:absolute;top:1px;right:0%; }

  </style>




<title>GridSter</title>
</head>

<body>


<?php


session_name("logintest");
session_start();


//ログイン関連　login.phpからの情報(ユーザー名、パス)を受け取る
if(empty($_POST["name"])||empty($_POST["pass"])){
	//echo "ログインデータを受け取っていません";

}else{

	//受け取った情報をクッキーに保存。ユーザー管理のため
	$_SESSION["logintest_user"]=$_POST["name"];
	$_SESSION["logintest_name"]=$_POST["name"];
	$_SESSION["logintest_pass"]=$_POST["pass"];
}


//MySQLに接続
try{
	$pdo=new PDO("mysql:host=localhost;dbname=nettest","root","3141592",
	array(
		PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'"
	));
}catch(PDOException $e){
	die($e->getMessage());
}


?>
<?php

//背景読み込み部分
$sql="SELECT background FROM user WHERE name='".$_SESSION["logintest_name"]."' AND pass='".$_SESSION["logintest_pass"]."'";
$result=$pdo->query($sql);

while($row=$result->fetch(PDO::FETCH_ASSOC)){
	$url=$row["background"];
	echo "<img class='bg' src='".$url."' alt='' />";

}


?>

<div id="container">

<div id="content" style="top:30px">

</div>


<div class="tools" id="tools">

<?php

//この文は意味のない文の可能性あり、、、
$sql="SELECT name FROM user WHERE name='".$_SESSION["logintest_name"]."' AND pass='".$_SESSION["logintest_pass"]."'";
$result=$pdo->query($sql);


if(!$result){
	//echo "データが取得できませんでした。出直してこい";
}

$uname=null;
while($row=$result->fetch(PDO::FETCH_ASSOC)){
	$uname=$row["name"];
}

if($uname!=null){
	//echo "<hr>ログイン認証成功！やったね！";
}else{
	//echo "<hr>ユーザ名が正しくないんだなぁ";

}



//MySQLから位置情報を読み出す部分

if(empty($_GET['data'])){
	//echo "<br>"."なにもありません"."<br>";
	if(empty($_POST["name"])||empty($_POST["pass"])){
	}else{
		$sql="SELECT data FROM user WHERE name='".$_SESSION["logintest_name"]."' AND pass='".$_SESSION["logintest_pass"]."'";
		$result=$pdo->query($sql);
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$data=$row["data"];
			//echo $data."aaa<br>";
		}
	}
}else{
	$data=$_GET['data'];
}


//読み出したデータを使えるように分解する　これの要素を分解⇒ex. {'x':1,'y':1,'width':1,'height':1,'id':1','name':null},{'x':1,'y':1,'width':1,'height':1,'id':2','name':null}]
$array=explode('}', $data);

$i=1;
$j=1;


foreach( $array as $value ){
  //echo $value."<br>";
  $j=0;
  $array2=explode(',', $value);
  foreach($array2 as $value2){
  	$kari=substr($value2,-1);
  	//echo $kari."<br>";
  	$d[$i][$j]=$kari;
  	//echo "$i=".$i."$j=".$j."<br>";
  	$j=$j+1;
  }

  $i=$i+1;
}
if(count($d)>1){
	for($i=4;$i>0;$i--){
		$aaa=$i-1;
		$k[$i]=$d[1][$i-1];
	}
	for($i=4;$i>0;$i--){
		$d[1][$i]=$k[$i];
	}
}


//↓JSでつかいます
$idnum=count($d);


//echo $data."<br>";

?>

<!--　保存、追加、ログアウトボタン表示部分　-->

<table>
	<tr>


		<td>
			<div class="alignC">
				<button style="background-color: green;color:white;" class="btn btn-primary" id="jump">保存</button>
			</div>

		</td>
		<td style="padding-top:16px">
		<?php
			echo "<form action=gridstr.php?data=".$data.",{'x':1,'y':1,'width':1,'height':1,'id':".count($d)."','name':null}] method='post'>";
		?>
			<input type="text" name="linkURL" value="リンクURL">
			<input type="text" name="picURL" value="画像URL">
			<input type="submit" value="追加" id="aaa" style="background-color: orange;color:white;">
			</form>
		</td>


	</tr>
</table>

<div align="right" class="logout">
	<!--
	<a href="./login.php">ログアウト</a>
	-->
	<form action=login.php method='post'>
	<input type="submit" value="ログアウト" id="kari" style="background-color: white;color:blue;">
	</form>
</div>




<?php


$num=$idnum-1;

$check=0;


//入力された画像URL、リンクURLをDBに保存する部分

if(empty($_POST["picURL"])||empty($_POST["linkURL"])){
}else{
	if($_POST["linkURL"]=="背景"){
		$sql="UPDATE user SET background='".$_POST["picURL"]."' WHERE name=".$_SESSION["logintest_name"];
		$sql."<br>";
		$result =$pdo->query($sql);;

	}else{
		$sql="UPDATE user SET URL".$num."='".$_POST["picURL"]."' WHERE name=".$_SESSION["logintest_name"];
		//echo $sql."<br>";
		$result =$pdo->query($sql);

		$sql="UPDATE user SET LINK".$num."='".$_POST["linkURL"]."' WHERE name=".$_SESSION["logintest_name"];
		//echo $sql."<br>";
		$result =$pdo->query($sql);
		if(!$result){
			//echo "画像URLデータ挿入できんかった";
		}else{
		//echo "画像URLデータ挿入しました";
		}
	}
	//echo "うけとってないよ<br>";
}

?>



<?php



//位置情報をDBに保存する部分
$sql="UPDATE user SET data="."'".$data."'"."WHERE name=".$_SESSION["logintest_name"];
//echo $sql;
$result =$pdo->query($sql);
if(!$result){
	//echo "データ挿入できんかった";
}else{
	//echo "データ挿入しました";
}



//echo $d[1][1]."<br>";


echo"<div class='layouts_grid' id='layouts_grid'>";
echo"<ul>";

$id=1;


//アイコン表示部分。DB内の画像URL、リンクURLを読み出して、順番に表示していく
for($i2=1;$i2<count($d);$i2++){


//画像をMySQLから取り出す
$pic="";

$sql="SELECT URL".$i2." FROM user WHERE name='".$_SESSION["logintest_name"]."' AND pass='".$_SESSION["logintest_pass"]."'";
//echo $sql."<br>";
$result=$pdo->query($sql);
while($row = $result->fetch(PDO::FETCH_ASSOC)){
	$kari="URL".$i2;
	$pic=$row[$kari];
}
//リンクをmySQLからとりだす
$link="";

$sql="SELECT LINK".$i2." FROM user WHERE name='".$_SESSION["logintest_name"]."' AND pass='".$_SESSION["logintest_pass"]."'";
//echo $sql."<br>";
$result=$pdo->query($sql);
while($row = $result->fetch(PDO::FETCH_ASSOC)){
	$kari="LINK".$i2;
	$link=$row[$kari];
}

		//ここが表示する際のコアの文

		echo "
		<li class='layout_block' data-id='".$id."' data-row='".$d[$i2][2]."' data-col='".$d[$i2][1]."' data-sizex='".$d[$i2][3]."' data-sizey='".$d[$i2][4]."' style='background-color: #D24726;'>
		<A Href=".$link."><Img Src=".$pic." width=100% height=100%></a>
		<div class='box'><div class='menu'>
		<div class='deleteme'><a  href='JavaScript:void(0);'>　</a></div>
		<div class='dragme'>　</div>
		</div></div>
		";

		echo"</li>";

		$id++;

}




?>


</div>
</div>

	<script type="text/javascript" src="./gridstr.js"></script>

</body>
</html>
