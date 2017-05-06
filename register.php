<?php

include('conn.php');

$username = $_POST['uid'];
$password = $_POST['pwd'];
$height = $_POST['height'];
$weigh = $_POST['weigh'];
$mail = $_POST['mail'];
$phone = $_POST['phone'];

$check_query = mysql_query("SELECT * FROM user WHERE username ='$username'");   

if(mysql_fetch_array($check_query)){

	$back['states']="-1";
	$back['info']="user has existed!";
	echo(json_encode($back));
}

else{

		$sql = "INSERT INTO user(username,password,regdate)VALUES('$username','$password',now())";
	
		if(mysql_query($sql,$conn)){
	    	$back['states']="1";
			$back['info']="successful!";
			echo(json_encode($back));
		} else {
			$back['states']="-2";
			$back['info']="error!";
	   	 	echo(json_encode($back));
		}
		/**********height*********/
		if($height){
			$sql_height = "UPDATE user SET height='$height' WHERE username='$username'";
			mysql_query($sql_height,$conn);
		}
		/*********weigh********/
		if($weigh){
			$sql_weigh = "UPDATE user SET weigh='$weigh' WHERE username='$username'";
			mysql_query($sql_weigh,$conn);
		}
		/*********mail*******/
		if($mail){
			$sql_mail = "UPDATE user SET email='$mail' WHERE username='$username'";
			mysql_query($sql_mail,$conn);
		}
		if($phone){
			$sql_phone = "UPDATE user SET phone_number='$phone' WHERE username='$username'";
			mysql_query($sql_phone,$conn);
		}

    }
mysql_close();
?>