<?php

//包含数据库连接文件
include('conn.php');

$username = $_POST['uid'];
$mail = $_POST['mail'];


//检测用户名是否已经存在
$check_query = mysql_query("select * from user where username='$username' limit 1");
//$result=mysql_fetch_assoc($sql);
$query = "UPDATE user SET email='$mail' WHERE username='$username'";
//$query = mysql_query("UPDATE user SET email='$mail', WHERE username='$username'");


if(mysql_fetch_array($check_query)){
	$result = mysql_query($query);
	if($result){
		$back['states']="1";
		$back['info']="successful!";
		echo(json_encode($back));
	
	}else{
		$back['states']="-2";
		$back['info']="update failed!";
		echo(json_encode($back));
	}	
}
//写入数据
else{
	$back['states']="-1";
	$back['info']="user hasn't existed!";
	echo(json_encode($back));
    }
mysql_close();
?>